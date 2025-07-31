<?php

namespace App\Services;

use App\Models\Visit;
use App\Models\Log as SyncLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as LaravelLog;

class VisitTrackingService
{
    public function trackVisit(string $ip, string $page): void
    {
        try {
            DB::transaction(function () use ($ip, $page) {
                Visit::create([
                    'ip_address' => $ip,
                    'page_url' => $page,
                    'visited_at' => now(),
                ]);

                LaravelLog::info("Visit saved for page: $page");

                SyncLog::log(
                    userName: 'guest',
                    userId: $ip,
                    status: 'success',
                    message: "Page visit tracked for $page"
                );
            });
        } catch (\Throwable $e) {
            LaravelLog::error('VisitTrackingService error', ['error' => $e->getMessage()]);

            SyncLog::log(
                userName: 'guest',
                userId: $ip,
                status: 'error',
                message: $e->getMessage()
            );

            throw $e;
        }
    }
}
