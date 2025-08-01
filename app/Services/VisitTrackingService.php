<?php

namespace App\Services;

use App\Models\Visit;
use App\Models\Log as SyncLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\GeoIPService;

class VisitTrackingService
{
    protected GeoIPService $geoService;

    public function __construct(GeoIPService $geoService)
    {
        $this->geoService = $geoService;
    }

    public function trackVisit(string $ip, string $page): void
    {
        try {
            $geo = $this->geoService->getGeo($ip);
            Log::info('Geo response', ['ip' => $ip, 'geo' => $geo]);

            DB::transaction(function () use ($ip, $page, $geo) {
                Visit::create([
                    'ip_address' => $ip,
                    'page_url'   => $page,
                    'visited_at' => now(),
                    'country'    => $geo['country'] ?? null,
                    'region'     => $geo['regionName'] ?? null,
                    'city'       => $geo['city'] ?? null,
                    'isp'        => $geo['isp'] ?? null,
                ]);

                SyncLog::log(
                    'guest',
                    $ip,
                    'success',
                    'Page visit tracked with geo'
                );
            });
        } catch (\Throwable $e) {
            Log::error('VisitTrackingService error', ['error' => $e->getMessage()]);

            SyncLog::log('guest', $ip, 'error', $e->getMessage());

            throw $e;
        }
    }
}
