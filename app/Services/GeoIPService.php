<?php

namespace App\Services;

use App\Contracts\GeoLocatorInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoIPService implements GeoLocatorInterface
{
    public function locate(string $ip): array
    {
      //  $ip = '62.73.122.119'; // Static for now (maybe mock/test), remove this for dynamic use
        try {
            $url = "http://ip-api.com/json/{$ip}";
            $response = Http::timeout(5)->get($url);

            if ($response->successful() && $response->json('status') === 'success') {
                return $response->json();
            }

            Log::warning('GeoIP lookup failed', [
                'ip' => $ip,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [];
        } catch (\Throwable $e) {
            Log::error('GeoIPService exception', ['ip' => $ip, 'error' => $e->getMessage()]);
            return [];
        }
    }
}
