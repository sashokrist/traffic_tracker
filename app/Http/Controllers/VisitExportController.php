<?php

namespace App\Http\Controllers;

use App\Mail\VisitReportMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Traits\GeneratesVisitReport;

class VisitExportController extends Controller
{
    use GeneratesVisitReport;

    public function export(Request $request)
    {
        $from = Carbon::parse($request->get('from', now()->subDays(7)))->startOfDay();
        $to = Carbon::parse($request->get('to', now()))->endOfDay();

        $filepath = $this->generateVisitReport($from, $to);
        $filename = basename($filepath);

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
