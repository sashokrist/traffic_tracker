<?php

namespace App\Services;

use App\Contracts\GeoLocatorInterface;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitTrackingService
{
    protected GeoLocatorInterface $geoService;
    protected LoggingService $logger;

    public function __construct(GeoLocatorInterface $geoService, LoggingService $logger)
    {
        $this->geoService = $geoService;
        $this->logger = $logger;
    }

    public function trackVisit(string $ip, string $page): void
    {
        try {
            $geo = $this->geoService->locate($ip);
            $this->logger->info('Geo response', ['ip' => $ip, 'geo' => $geo]);

            DB::transaction(function () use ($ip, $page, $geo) {
                $this->logger->info('Inserting visit', [
                    'ip' => $ip,
                    'page' => $page,
                    'geo' => $geo,
                ]);
                Visit::create([
                    'ip_address' => $ip,
                    'page_url'   => $page,
                    'visited_at' => now(),
                    'country'    => $geo['country'] ?? null,
                    'region'     => $geo['regionName'] ?? null,
                    'city'       => $geo['city'] ?? null,
                    'isp'        => $geo['isp'] ?? null,
                ]);

                $this->logger->success('guest', $ip, 'Page visit tracked with geo');
            });
        } catch (\Throwable $e) {
            $this->logger->error('guest', $ip, $e->getMessage());
            throw $e;
        }
    }
}
