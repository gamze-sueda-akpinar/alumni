<?php

namespace App\Http\Middleware;

use App\Support\ErrorLogger;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Class Guardian5xxMiddleware
 *
 * 5xx Guardian Middleware intercepts internal server errors (500-599),
 * prevents sensitive stack traces from leaking, logs the full trace with
 * a unique reference ID, and returns a safe, structured response containing
 * an explicit "reason".
 *
 * @package App\Http\Middleware
 */
class Guardian5xxMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            /** @var Response $response */
            $response = $next($request);
        } catch (Throwable $e) {
            return $this->handleThrowable($request, $e);
        }

        // If downstream returned a 5xx HTTP status code directly
        if ($response->getStatusCode() >= 500 && $response->getStatusCode() <= 599) {
            return $this->intercept5xxResponse($request, $response);
        }

        return $response;
    }

    /**
     * Handle uncaught throwables by generating a reference ID and structured response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleThrowable(Request $request, Throwable $e): Response
    {
        $referenceId = 'ERR-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        $statusCode = ($e instanceof HttpExceptionInterface && $e->getStatusCode() >= 500)
            ? $e->getStatusCode()
            : 500;

        // Log the complete diagnostic trace with the unique reference ID
        Log::error(sprintf(
            "[5xx Guardian] [%s] %s on route [%s] %s: %s in %s:%d",
            $referenceId,
            get_class($e),
            strtoupper($request->method()),
            '/' . ltrim($request->path(), '/'),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        ), [
            'reference_id' => $referenceId,
            'exception' => $e,
            'url' => $request->fullUrl(),
            'client_ip' => $request->ip(),
        ]);

        $reason = $this->resolveReason($e);

        return $this->build5xxResponse($request, $statusCode, $reason, $referenceId, $e);
    }

    /**
     * Intercept existing 5xx response and enrich it with reference ID and explicit reason.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function intercept5xxResponse(Request $request, Response $response): Response
    {
        $referenceId = 'ERR-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        $statusCode = $response->getStatusCode();
        $reason = null;

        $content = $response->getContent();
        if (!empty($content)) {
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                $reason = $decoded['reason'] ?? $decoded['message'] ?? null;
            }
        }

        if (!$reason) {
            $reason = sprintf(
                "An unexpected server error occurred while processing [%s] /%s.",
                strtoupper($request->method()),
                ltrim($request->path(), '/')
            );
        }

        return $this->build5xxResponse($request, $statusCode, $reason, $referenceId);
    }

    /**
     * Resolve a safe, contextual reason string.
     *
     * @param  \Throwable  $e
     * @return string
     */
    protected function resolveReason(Throwable $e): string
    {
        $isDebug = config('app.debug', false);

        // In debug mode, expose the specific exception message
        if ($isDebug && !empty($e->getMessage())) {
            return $e->getMessage();
        }

        // Safe production messages based on exception type
        if ($e instanceof \Illuminate\Database\QueryException) {
            return "A database operation failed while executing your request. Please try again shortly.";
        }

        return "An internal server error occurred while processing your request. Our engineering team has been notified.";
    }

    /**
     * Build the structured 5xx response (JSON or HTML view).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $statusCode
     * @param  string  $reason
     * @param  string  $referenceId
     * @param  \Throwable|null  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function build5xxResponse(
        Request $request,
        int $statusCode,
        string $reason,
        string $referenceId,
        ?Throwable $e = null
    ): Response {
        $routePath = '/' . ltrim($request->path(), '/');

        // Persist 5xx error details directly to logs/error.logs
        ErrorLogger::log("HTTP {$statusCode} ERROR", $reason, [
            'reference_id' => $referenceId,
            'method' => strtoupper($request->method()),
            'path' => $routePath,
            'exception' => $e ? get_class($e) : 'Direct5xxResponse',
            'file' => $e ? basename($e->getFile()) . ':' . $e->getLine() : null,
            'ip' => $request->ip(),
        ]);

        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            $payload = [
                'status' => $statusCode,
                'error' => 'Internal Server Error',
                'reason' => $reason,
                'reference_id' => $referenceId,
                'path' => $routePath,
                'method' => strtoupper($request->method()),
                'timestamp' => now()->toIso8601String(),
            ];

            if (config('app.debug', false) && $e !== null) {
                $payload['debug'] = [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
            }

            return new JsonResponse($payload, $statusCode, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        // Return Blade error view if available
        if (view()->exists('errors.500')) {
            return new HttpResponse(
                view('errors.500', [
                    'statusCode' => $statusCode,
                    'reason' => $reason,
                    'referenceId' => $referenceId,
                    'path' => $routePath,
                    'method' => strtoupper($request->method()),
                    'exception' => config('app.debug', false) ? $e : null,
                ])->render(),
                $statusCode,
                ['Content-Type' => 'text/html; charset=utf-8']
            );
        }

        // Minimal fallback HTML
        return new HttpResponse(
            $this->renderFallbackHtml($request, $statusCode, $reason, $referenceId),
            $statusCode,
            ['Content-Type' => 'text/html; charset=utf-8']
        );
    }

    /**
     * Minimal fallback HTML markup if Blade view is unavailable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $statusCode
     * @param  string  $reason
     * @param  string  $referenceId
     * @return string
     */
    protected function renderFallbackHtml(Request $request, int $statusCode, string $reason, string $referenceId): string
    {
        $safeReason = htmlspecialchars($reason, ENT_QUOTES, 'UTF-8');
        $safePath = htmlspecialchars('/' . ltrim($request->path(), '/'), ENT_QUOTES, 'UTF-8');
        $safeMethod = htmlspecialchars(strtoupper($request->method()), ENT_QUOTES, 'UTF-8');
        $safeRef = htmlspecialchars($referenceId, ENT_QUOTES, 'UTF-8');

        return <<<HTML
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{$statusCode} Server Error - 5xx Guardian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 text-slate-800">
    <div class="max-w-lg w-full bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center">
        <span class="text-6xl block mb-4">🛡️</span>
        <h1 class="text-2xl font-extrabold text-slate-900 mb-2">{$statusCode} - Sunucu Hatası</h1>
        <p class="text-sm font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-xl p-4 mb-4">
            <strong>Neden (Reason):</strong> {$safeReason}
        </p>
        <p class="text-xs text-slate-500 font-mono mb-6">Referans Kodu: <strong class="text-indigo-600">{$safeRef}</strong></p>
        <a href="/main" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition">
            Ana Sayfaya Dön
        </a>
    </div>
</body>
</html>
HTML;
    }
}
