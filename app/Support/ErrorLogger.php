<?php

namespace App\Support;

/**
 * Class ErrorLogger
 *
 * Utility service to persist structured middleware and application errors
 * into the dedicated "logs/error.logs" file and request traces into "logs/requests.log".
 */
class ErrorLogger
{
    /**
     * Absolute path to the primary error log file (logs/error.logs).
     */
    public static function errorLogPath(): string
    {
        return base_path('logs/error.logs');
    }

    /**
     * Absolute path to the requests log file (logs/requests.log).
     */
    public static function requestsLogPath(): string
    {
        return base_path('logs/requests.log');
    }

    /**
     * Append an error entry to logs/error.logs.
     *
     * @param  string  $level       e.g. '404 NOT FOUND', '500 SERVER ERROR', 'CRITICAL'
     * @param  string  $message     Human-readable error reason
     * @param  array   $details     Context attributes (method, route, reference_id, ip, etc.)
     * @return void
     */
    public static function log(string $level, string $message, array $details = []): void
    {
        self::ensureDirectoryExists();

        $timestamp = date('Y-m-d H:i:s');
        $detailParts = [];
        foreach ($details as $key => $val) {
            if (is_array($val) || is_object($val)) {
                $val = json_encode($val, JSON_UNESCAPED_SLASHES);
            }
            $detailParts[] = "{$key}={$val}";
        }
        $detailStr = !empty($detailParts) ? ' [' . implode(', ', $detailParts) . ']' : '';

        $entry = sprintf("[%s] [%s] %s%s%s", $timestamp, strtoupper($level), $message, $detailStr, PHP_EOL);

        @file_put_contents(self::errorLogPath(), $entry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Append a request trace line to logs/requests.log.
     *
     * @param  string  $line
     * @return void
     */
    public static function logRequest(string $line): void
    {
        self::ensureDirectoryExists();
        @file_put_contents(self::requestsLogPath(), $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    /**
     * Ensure the target logs directory exists and is writable.
     */
    protected static function ensureDirectoryExists(): void
    {
        $dir = base_path('logs');
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
    }
}
