<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackVisitRequest;
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

    public function track(TrackVisitRequest $request)
    {
        $ip = $request->ip();
        $page = $request->validated()['page'];

        $this->logger->info('Calling VisitTrackingService from VisitController');

        try {
            $this->trackingService->trackVisit($ip, $page);
            return response()->noContent();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Visit log failed'], 500);
        }
    }
}
