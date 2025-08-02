<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Log as SyncLog;

class LoggingService
{
    public function info(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }

    public function error(string $source, string $ip, string $message): void
    {
        Log::error($message, ['source' => $source, 'ip' => $ip]);

        SyncLog::log($source, $ip, 'error', $message);
    }

    public function success(string $source, string $ip, string $message): void
    {
        Log::info($message, ['source' => $source, 'ip' => $ip]);

        SyncLog::log($source, $ip, 'success', $message);
    }
}
