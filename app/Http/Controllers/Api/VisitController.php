<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VisitTrackingService;
use App\Services\LoggingService;

class VisitController extends Controller
{
    protected VisitTrackingService $trackingService;
    protected LoggingService $logger;

    public function __construct(VisitTrackingService $trackingService, LoggingService $logger)
    {
        $this->trackingService = $trackingService;
        $this->logger = $logger;
    }

    public function track(Request $request)
    {
        $ip = $request->ip();
        $page = $request->query('page');

        if (!$page) return response()->noContent();

        $this->logger->info('Tracking request received', ['ip' => $ip, 'page' => $page]); // ← Add this
        try {
            $this->logger->info('Calling VisitTrackingService from VisitController');
            $this->trackingService->trackVisit($ip, $page);
            return response()->noContent();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Visit log failed'], 500);
        }
    }
}
