<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Prepend LoggerMiddleware as the very first global middleware for all requests
        $middleware->prepend(\App\Http\Middleware\LoggerMiddleware::class);

        // Register 404 Guardian Middleware to intercept and format 404 responses with reasons
        $middleware->append(\App\Http\Middleware\Guardian404Middleware::class);

        // Register 5xx Guardian Middleware to intercept and format 5xx server errors safely with reasons & reference IDs
        $middleware->append(\App\Http\Middleware\Guardian5xxMiddleware::class);

        $middleware->validateCsrfTokens(except: [
            'api/*',
            'users',
            'users/*',
            'announcements',
            'announcements/*',
            'job-postings',
            'job-postings/*',
            'applications',
            'applications/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
            $reason = null;

            // Check if triggered by ModelNotFoundException
            if ($e->getPrevious() instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $prev = $e->getPrevious();
                $model = class_basename($prev->getModel());
                $ids = implode(', ', (array) $prev->getIds());
                $reason = $ids ? "The requested {$model} with ID ({$ids}) could not be found." : "The requested {$model} record could not be found.";
            }

            if (!$reason) {
                $rawMsg = $e->getMessage();
                $reason = (!empty($rawMsg) && !str_starts_with($rawMsg, 'The route') && !str_starts_with($rawMsg, 'Not Found'))
                    ? $rawMsg
                    : "The requested route '[" . strtoupper($request->method()) . "] /" . ltrim($request->path(), '/') . "' was not found on this server.";
            }

            $routePath = '/' . ltrim($request->path(), '/');

            // Persist 404 to logs/error.logs
            \App\Support\ErrorLogger::log('404 NOT FOUND', $reason, [
                'method' => strtoupper($request->method()),
                'path' => $routePath,
                'ip' => $request->ip(),
            ]);

            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'status' => 404,
                    'error' => 'Not Found',
                    'reason' => $reason,
                    'path' => $routePath,
                    'method' => strtoupper($request->method()),
                    'timestamp' => now()->toIso8601String(),
                ], 404, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }

            return response()->view('errors.404', [
                'reason' => $reason,
                'path' => $routePath,
                'method' => strtoupper($request->method()),
            ], 404);
        });

        // 5xx Guardian Exception Handler
        $exceptions->render(function (\Throwable $e, Request $request) {
            // Let 404 exceptions pass to 404 handler
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ||
                $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return null;
            }

            // Only handle 5xx server errors
            $statusCode = 500;
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                $code = $e->getStatusCode();
                if ($code < 500) {
                    return null; // Let 4xx client errors pass through
                }
                $statusCode = $code;
            }

            $referenceId = 'ERR-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
            \Illuminate\Support\Facades\Log::error(sprintf(
                "[5xx Guardian] [%s] %s on route [%s] %s: %s",
                $referenceId,
                get_class($e),
                strtoupper($request->method()),
                '/' . ltrim($request->path(), '/'),
                $e->getMessage()
            ), [
                'reference_id' => $referenceId,
                'exception' => $e,
            ]);

            $reason = config('app.debug') && !empty($e->getMessage())
                ? $e->getMessage()
                : "An unexpected internal server error occurred while processing your request. Please contact support with reference ID: {$referenceId}.";

            $routePath = '/' . ltrim($request->path(), '/');

            // Persist 5xx to logs/error.logs
            \App\Support\ErrorLogger::log("HTTP {$statusCode} ERROR", $reason, [
                'reference_id' => $referenceId,
                'method' => strtoupper($request->method()),
                'path' => $routePath,
                'exception' => get_class($e),
                'file' => basename($e->getFile()) . ':' . $e->getLine(),
                'ip' => $request->ip(),
            ]);

            if ($request->is('api/*') || $request->expectsJson()) {
                $payload = [
                    'status' => $statusCode,
                    'error' => 'Internal Server Error',
                    'reason' => $reason,
                    'reference_id' => $referenceId,
                    'path' => $routePath,
                    'method' => strtoupper($request->method()),
                    'timestamp' => now()->toIso8601String(),
                ];

                if (config('app.debug')) {
                    $payload['debug'] = [
                        'exception' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ];
                }

                return response()->json($payload, $statusCode, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }

            return response()->view('errors.500', [
                'statusCode' => $statusCode,
                'reason' => $reason,
                'referenceId' => $referenceId,
                'path' => $routePath,
                'method' => strtoupper($request->method()),
                'exception' => config('app.debug') ? $e : null,
            ], $statusCode);
        });
    })->create();
