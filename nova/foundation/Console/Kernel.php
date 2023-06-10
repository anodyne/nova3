<?php

declare(strict_types=1);

namespace Nova\Foundation\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('cache:prune-stale-tags')->hourly();

        // Delete any posts that are considered abandoned
        $schedule->command('nova:prune-abandoned-posts')->daily();

        // Send a notification to users if they haven't posted in X days
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require nova_path('routes/console.php');
    }
}
