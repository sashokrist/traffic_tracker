<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackVisitRequest;
use Illuminate\Http\Request;
use App\Services\VisitTrackingService;
use App\Services\LoggingService;
use OpenApi\Annotations as OA;


class VisitController extends Controller
{
    protected VisitTrackingService $trackingService;
    protected LoggingService $logger;

    public function __construct(VisitTrackingService $trackingService, LoggingService $logger)
    {
        $this->trackingService = $trackingService;
        $this->logger = $logger;
    }

    /**
     * @OA\Get(
     *     path="/api/track",
     *     operationId="trackVisit",
     *     tags={"Visits"},
     *     summary="Track a page visit",
     *     description="Tracks visits and logs them with geo location",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Full page URL",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Visit logged successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing or invalid page parameter"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
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
