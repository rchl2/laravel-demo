<?php

namespace App\Console;

use App\Queries\UserQueries;
use App\Queries\ShopPromotionsQueries;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     */
    protected $commands = [
        Commands\DeleteExpiredPromotions::class,
        Commands\DeleteExpiredBans::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        /*
         * Remove expired promotions.
         * This executes only when there is more than zero expired promotions.
         */
        $schedule->command('promotions:delete')
            ->everyMinute()
            ->when(function () {
                return (ShopPromotionsQueries::countExpiredPromotions() > 0) ? true : false;
            })
            ->appendOutputTo(storage_path('logs/command_expired_promotions.log'));

        /*
         * Remove expired users bans.
         * This executes only when there is more than zero users with expired bans.
         */
        $schedule->command('bans:delete')
            ->everyFiveMinutes()
            ->when(function () {
                return (UserQueries::countWithExpiredBans() > 0) ? true : false;
            })
            ->appendOutputTo(storage_path('logs/command_expired_bans.log'));

        /*
         * Horizon snapshots.
         */
        $schedule->command('horizon:snapshot')
            ->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
