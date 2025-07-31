<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VisitTrackingService;
use Illuminate\Support\Facades\Log as LaravelLog;

class VisitController extends Controller
{
    protected VisitTrackingService $trackingService;

    public function __construct(VisitTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    public function track(Request $request)
    {
        $ip = $request->ip();
        $page = $request->query('page');

        if (!$page) return response()->noContent();

        try {
            LaravelLog::info('Calling VisitTrackingService from VisitController');

            $this->trackingService->trackVisit($ip, $page);

            return response()->noContent();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Visit log failed'], 500);
        }
    }
}
