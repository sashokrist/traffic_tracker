<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Visit;
use Carbon\Carbon;

class VisitReportService
{
    public function getUniqueVisits(Carbon $from, Carbon $to)
    {
        $key = "unique_visits:{$from->toDateString()}_{$to->toDateString()}";

        return Cache::remember($key, now()->addMinutes(5), function () use ($from, $to) {
            return Visit::select('page_url')
                ->selectRaw('COUNT(DISTINCT ip_address) as unique_visits')
                ->whereBetween('visited_at', [$from, $to])
                ->groupBy('page_url')
                ->get();;
        });
    }

    public function getAllVisits(Carbon $from, Carbon $to)
    {
        return Visit::whereBetween('visited_at', [$from, $to])
            ->orderByDesc('visited_at')
            ->paginate(20);
    }
}
