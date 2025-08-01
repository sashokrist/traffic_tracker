<?php

namespace App\Traits;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait GeneratesVisitReport
{
    public function generateVisitReport(Carbon $from, Carbon $to): string
    {
        $filename = 'visit_report_' . now()->format('Ymd_His') . '.csv';
        $filepath = 'reports/' . $filename;

        Storage::makeDirectory('reports');

        $handle = fopen(storage_path("app/{$filepath}"), 'w');
        fputcsv($handle, [
            'Page URL',
            'IP Address',
            'Visited At',
            'Referrer',
            'Country',
            'Region',
            'City',
            'ISP',
        ]);

        Visit::whereBetween('visited_at', [$from, $to])
            ->orderByDesc('visited_at')
            ->chunk(100, function ($visits) use ($handle) {
                foreach ($visits as $visit) {
                    fputcsv($handle, [
                        $visit->page_url,
                        $visit->ip_address,
                        $visit->visited_at,
                        $visit->referrer ?? 'N/A',
                        $visit->country ?? '',
                        $visit->region ?? '',
                        $visit->city ?? '',
                        $visit->isp ?? '',
                    ]);
                }
            });

        fclose($handle);

        return $filepath;
    }
}
