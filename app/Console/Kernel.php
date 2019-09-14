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
        ClaimCommand::class,
        PdtCommand::class,
        PstCommand::class,
        AddsCommand::class,
        MatchupCommand::class,
        WaiverCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('theleague:pst')->cron('30 11 3 11 *'); // 03:30 03 November 2019
        $schedule->command('theleague:pdt')->cron('30 10 8 3 *'); // 03:30 08 March 2020
        $schedule->command('theleague:adds')->mondays()->at('08:00');
        $schedule->command('theleague:lineup')->everyMinute();

        $schedule->command('theleague:date')->dailyAt('12:03');
        $schedule->command('theleague:matchup')->dailyAt('12:03');
        $schedule->command('theleague:claim')->dailyAt('12:03');
        $schedule->command('theleague:waiver')->dailyAt('12:03');
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
