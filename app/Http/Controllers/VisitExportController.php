<?php

namespace App\Http\Controllers;

use App\Mail\VisitReportMail;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class VisitExportController extends Controller
{

    public function export(Request $request)
    {
        $from = Carbon::parse($request->get('from', now()->subDays(7)))->startOfDay();
        $to = Carbon::parse($request->get('to', now()))->endOfDay();

        $filename = 'visit_report_' . now()->format('Ymd_His') . '.csv';
        $filepath = 'reports/' . $filename;

        Storage::makeDirectory('reports');

        $handle = fopen(storage_path("app/{$filepath}"), 'w');
        fputcsv($handle, ['Page URL', 'IP Address', 'Visited At']);

        Visit::whereBetween('visited_at', [$from, $to])
            ->orderByDesc('visited_at')
            ->chunk(100, function ($visits) use ($handle) {
                foreach ($visits as $visit) {
                    fputcsv($handle, [
                        $visit->page_url,
                        $visit->ip_address,
                        $visit->visited_at,
                    ]);
                }
            });

        fclose($handle);

        // Send email
        Mail::to(auth()->user()->email)->send(new VisitReportMail($filepath));

        return redirect()
            ->back()
            ->with('report_download', route('visits.download', ['filename' => $filename]))
            ->with('message', 'Report sent to your email.');
    }

    public function download($filename)
    {
        $path = 'reports/' . $filename;

        if (!Storage::exists($path)) {
            abort(404, 'Report not found');
        }

        return Storage::download($path);
    }
}
