<?php

namespace App\Http\Middleware;

use App\Support\ErrorLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoggerMiddleware
 *
 * Global top-level middleware that logs incoming HTTP requests directly to the terminal.
 * Output format: time method route res.type duration
 * Example row:   10:20:30 POST /user             201      18ms
 *
 * @package App\Http\Middleware
 */
class LoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Record high-resolution start time
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);

        try {
            /** @var Response $response */
            $response = $next($request);
            $statusCode = $response->getStatusCode();
        } catch (\Throwable $e) {
            $statusCode = 500;
            $this->logRequest($request, $statusCode, $startTime);
            throw $e;
        }

        $this->logRequest($request, $statusCode, $startTime);

        return $response;
    }

    /**
     * Format and write the request log entry to the terminal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $statusCode
     * @param  float  $startTime
     * @return void
     */
    protected function logRequest(Request $request, int $statusCode, float $startTime): void
    {
        $durationMs = max(1, (int) round((microtime(true) - $startTime) * 1000));
        $time = date('H:i:s');
        $method = strtoupper($request->method());
        $route = '/' . ltrim($request->path(), '/');

        // Format: time method route res.type duration
        // Example: 10:20:30 POST /user             201      18ms
        $logLine = sprintf(
            "%-8s %-6s %-24s %-8s %s",
            $time,
            $method,
            $route,
            $statusCode,
            $durationMs . 'ms'
        );

        $this->writeToTerminal($logLine);

        // Persist request trace to logs/requests.log
        ErrorLogger::logRequest($logLine);

        // If response is an error (4xx or 5xx), also record in logs/error.logs
        if ($statusCode >= 400) {
            ErrorLogger::log(
                "HTTP {$statusCode}",
                "Request resulted in HTTP {$statusCode} on [{$method}] {$route}",
                [
                    'status' => $statusCode,
                    'duration' => $durationMs . 'ms',
                    'ip' => $request->ip(),
                ]
            );
        }
    }

    /**
     * Write formatted log entry directly to standard output stream (terminal).
     *
     * @param  string  $message
     * @return void
     */
    protected function writeToTerminal(string $message): void
    {
        // Direct write to stdout (CLI, artisan serve, Docker container output)
        if (defined('STDOUT') && is_resource(STDOUT)) {
            @fwrite(STDOUT, $message . PHP_EOL);
        } else {
            $written = @file_put_contents('php://stdout', $message . PHP_EOL);
            if ($written === false) {
                @file_put_contents('php://stderr', $message . PHP_EOL);
            }
        }
    }
}
