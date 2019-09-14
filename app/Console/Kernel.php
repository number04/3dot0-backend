<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DateCommand::class,
        LineupCommand::class,
        ClaimCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('theleague:pst')->cron('30 11 3 11 *');
        $schedule->command('theleague:pdt')->cron('30 10 8 3 *');

        $schedule->command('theleague:date')->dailyAt('08:00');
        $schedule->command('theleague:claim')->dailyAt('08:00');


        $schedule->command('theleague:lineup')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
