<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Visit;
use App\Services\VisitReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class VisitReportServiceTest extends TestCase
{
    public function test_get_unique_visits_caches_results()
    {
        // Arrange
        $from = Carbon::now()->subDays(7);
        $to = Carbon::now();
        $cacheKey = "unique_visits:{$from->toDateString()}_{$to->toDateString()}";

        Cache::shouldReceive('remember')
            ->once()
            ->with($cacheKey, \Mockery::type('DateTime'), \Mockery::type('Closure'))
            ->andReturn(collect([
                ['page_url' => '/home', 'unique_visits' => 5],
            ]));

        $service = new VisitReportService();

        // Act
        $result = $service->getUniqueVisits($from, $to);

        // Assert
        $this->assertCount(1, $result);
        $this->assertEquals('/home', $result->first()['page_url']);
        $this->assertEquals(5, $result->first()['unique_visits']);
    }

    public function test_get_all_visits_returns_paginated_results()
    {
        // Arrange
        $from = Carbon::now()->subDays(7);
        $to = Carbon::now();

        // Insert test rows with identifiable tag
        $tag = 'test-tag-' . uniqid();
        Visit::factory()->count(30)->create([
            'visited_at' => Carbon::now()->subDays(3),
            'page_url' => $tag, // for cleanup if needed
        ]);

        $service = new VisitReportService();

        // Act
        $result = $service->getAllVisits($from, $to);

        // Assert
        $this->assertEquals(20, $result->count()); // Laravel default page size
        $this->assertTrue(
            Carbon::parse($result->first()->visited_at)
                ->isAfter(\Carbon\Carbon::parse($result->last()->visited_at))
        );


        // Optional: delete inserted rows
        Visit::where('page_url', $tag)->delete();
    }
}
