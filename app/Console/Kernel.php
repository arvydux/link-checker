<?php

namespace App\Console;

use App\Models\Link;
use App\Services\LinkCheckService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $links = Link::all();

            $linkCheckService = new LinkCheckService();
            foreach ($links as $link) {
                $linkCheckService->checkLink($link);
            }
        })->twiceDaily(2, 18);;
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
