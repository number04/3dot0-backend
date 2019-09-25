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
        WaiverCommand::class,
        StatsCommand::class,
        InjuryCommand::class,
        AwardCommand::class,
        StandingCommand::class
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

        $schedule->command('theleague:adds')->mondays()->at('08:10'); // 110am PDT | 1210am PST
        $schedule->command('theleague:award')->mondays()->at('08:10'); // 110am PDT | 1210am PST
        $schedule->command('theleague:standing')->mondays()->at('08:10'); // 110am PDT | 1210am PST

        $schedule->command('theleague:lineup')->everyMinute()->unlessBetween('8:00', '15:00'); // 1am - 8am PDT | 12am - 7am PST
        // $schedule->command('theleague:stats')->everyFiveMinutes()->unlessBetween('8:00', '15:00'); // 1am - 8am PDT | 12am - 7am PST
        $schedule->command('theleague:injury')->everyFiveMinutes()->unlessBetween('8:00', '15:00'); // 1am - 8am PDT | 12am - 7am PST

        $schedule->command('theleague:date')->dailyAt('8:00'); // 1am PDT | 12am PST
        $schedule->command('theleague:matchup')->dailyAt('8:00'); // 1am PDT | 12am PST
        $schedule->command('theleague:claim')->dailyAt('8:00'); // 1am PDT | 12am PST
        $schedule->command('theleague:waiver')->dailyAt('8:00'); // 1am PDT | 12am PST
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
