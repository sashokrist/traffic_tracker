<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VisitReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Log as SyncLog;

class DashboardController extends Controller
{
    protected $visitService;

    public function __construct(VisitReportService $visitService)
    {
        $this->visitService = $visitService;
    }

    public function index(Request $request)
    {
        $ip = $request->ip();

        try {
            $from = Carbon::parse($request->get('from', now()->subDays(7)))->startOfDay();
            $to = Carbon::parse($request->get('to', now()))->endOfDay();

            DB::beginTransaction();

            $uniqueData = $this->visitService->getUniqueVisits($from, $to);
            $allData = $this->visitService->getAllVisits($from, $to);

            DB::commit();

            SyncLog::log(
                userName: auth()->check() ? auth()->user()->name : 'admin',
                userId: auth()->check() ? auth()->id() : $ip,
                status: 'success',
                message: 'Dashboard data loaded'
            );

            return view('dashboard', compact('uniqueData', 'allData', 'from', 'to'));
        } catch (\Throwable $e) {
            DB::rollBack();

            SyncLog::log(
                userName: auth()->check() ? auth()->user()->name : 'admin',
                userId: auth()->check() ? auth()->id() : $ip,
                status: 'error',
                message: $e->getMessage()
            );

            return back()->withErrors('Unable to load dashboard data.');
        }
    }
}
