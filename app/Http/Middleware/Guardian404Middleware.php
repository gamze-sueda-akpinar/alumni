<?php

namespace App\Http\Middleware;

use App\Support\ErrorLogger;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Guardian404Middleware
 *
 * 404 Guardian Middleware intercepts all 404 Not Found occurrences across the application
 * and guarantees a structured, informative response with an explicit "reason" explaining
 * why the resource or route could not be found.
 *
 * @package App\Http\Middleware
 */
class Guardian404Middleware
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
        } catch (ModelNotFoundException $e) {
            $reason = $this->resolveModelNotFoundReason($e, $request);
            return $this->build404Response($request, $reason);
        } catch (NotFoundHttpException $e) {
            $reason = $this->resolveNotFoundHttpReason($e, $request);
            return $this->build404Response($request, $reason);
        }

        // If the downstream controller or exception handler returned a 404 status
        if ($response->getStatusCode() === 404) {
            return $this->intercept404Response($request, $response);
        }

        return $response;
    }

    /**
     * Intercept and enrich existing 404 responses with an explicit reason.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function intercept404Response(Request $request, Response $response): Response
    {
        $existingReason = null;

        // Try extracting reason from existing JSON body or status text
        $content = $response->getContent();
        if (!empty($content)) {
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                $existingReason = $decoded['reason'] ?? $decoded['message'] ?? null;
            }
        }

        $reason = $existingReason ?: $this->deduceReason($request);

        return $this->build404Response($request, $reason);
    }

    /**
     * Build standard 404 response containing the explicit reason (JSON or HTML view).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $reason
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function build404Response(Request $request, string $reason): Response
    {
        $routePath = '/' . ltrim($request->path(), '/');

        // Persist 404 error details to logs/error.logs
        ErrorLogger::log('404 NOT FOUND', $reason, [
            'method' => strtoupper($request->method()),
            'path' => $routePath,
            'ip' => $request->ip(),
        ]);

        // Return structured JSON for API or requests expecting JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return new JsonResponse([
                'status' => 404,
                'error' => 'Not Found',
                'reason' => $reason,
                'path' => $routePath,
                'method' => strtoupper($request->method()),
                'timestamp' => now()->toIso8601String(),
            ], 404, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        // Return HTML view for browser requests if error view exists
        if (view()->exists('errors.404')) {
            return new HttpResponse(
                view('errors.404', [
                    'reason' => $reason,
                    'path' => $routePath,
                    'method' => strtoupper($request->method()),
                ])->render(),
                404,
                ['Content-Type' => 'text/html; charset=utf-8']
            );
        }

        // Fallback plain HTML response with explicit reason
        return new HttpResponse(
            $this->renderFallbackHtml($request, $reason),
            404,
            ['Content-Type' => 'text/html; charset=utf-8']
        );
    }

    /**
     * Deduce a clear, human-readable reason based on the requested route and context.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function deduceReason(Request $request): string
    {
        $path = '/' . ltrim($request->path(), '/');
        $from = $request->query('from');
        if ($path === '/404' && !empty($from)) {
            return sprintf("The requested page '%s' was not found on this server.", $from);
        }

        $segments = $request->segments();
        $lastSegment = end($segments);

        // If the path ends with a numeric identifier on a resource route (e.g. /users/999 or /job-postings/999)
        if (is_numeric($lastSegment) && count($segments) > 1) {
            $resourceName = prev($segments) ?: 'resource';
            return sprintf(
                "No %s record was found with ID '%s' on route '%s'.",
                rtrim($resourceName, 's'),
                $lastSegment,
                $path
            );
        }

        return sprintf(
            "The requested route '[%s] %s' does not exist on this server.",
            strtoupper($request->method()),
            $path
        );
    }

    /**
     * Resolve descriptive reason for ModelNotFoundException.
     *
     * @param  \Illuminate\Database\Eloquent\ModelNotFoundException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function resolveModelNotFoundReason(ModelNotFoundException $e, Request $request): string
    {
        $model = class_basename($e->getModel());
        $ids = implode(', ', (array) $e->getIds());

        if (!empty($ids)) {
            return sprintf("The requested %s with ID (%s) could not be found.", $model, $ids);
        }

        return sprintf("The requested %s record could not be found on '%s'.", $model, '/' . ltrim($request->path(), '/'));
    }

    /**
     * Resolve descriptive reason for NotFoundHttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\NotFoundHttpException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function resolveNotFoundHttpReason(NotFoundHttpException $e, Request $request): string
    {
        $message = $e->getMessage();
        if (!empty($message) && !str_starts_with($message, 'The route') && !str_starts_with($message, 'Not Found')) {
            return $message;
        }

        return sprintf("The requested route '[%s] /%s' does not exist on this server.", strtoupper($request->method()), ltrim($request->path(), '/'));
    }

    /**
     * Minimal fallback HTML markup if Blade view is unavailable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $reason
     * @return string
     */
    protected function renderFallbackHtml(Request $request, string $reason): string
    {
        $safeReason = htmlspecialchars($reason, ENT_QUOTES, 'UTF-8');
        $safePath = htmlspecialchars('/' . ltrim($request->path(), '/'), ENT_QUOTES, 'UTF-8');
        $safeMethod = htmlspecialchars(strtoupper($request->method()), ENT_QUOTES, 'UTF-8');

        return <<<HTML
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found - 404 Guardian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 text-slate-800">
    <div class="max-w-lg w-full bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center">
        <span class="text-6xl block mb-4">🛡️</span>
        <h1 class="text-2xl font-extrabold text-slate-900 mb-2">404 - Kaynak Bulunamadı</h1>
        <p class="text-sm font-semibold text-rose-600 bg-rose-50 border border-rose-200 rounded-xl p-4 mb-6">
            <strong>Neden (Reason):</strong> {$safeReason}
        </p>
        <p class="text-xs text-slate-400 mb-6 font-mono">Rota: [{$safeMethod}] {$safePath}</p>
        <a href="/main" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition">
            Ana Sayfaya Dön
        </a>
    </div>
</body>
</html>
HTML;
    }
}
