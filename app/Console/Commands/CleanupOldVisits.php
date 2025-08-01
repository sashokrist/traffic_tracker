<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Visit;
use Carbon\Carbon;

class CleanupOldVisits extends Command
{
    protected $signature = 'visits:cleanup {days=30}';
    protected $description = 'Delete visit records older than X days';

    public function handle()
    {
        $days = (int) $this->argument('days');
        $cutoff = now()->subDays($days);

        $count = Visit::where('visited_at', '<', $cutoff)->delete();

        $this->info("Deleted $count old visit(s) older than $days days.");
    }
}
