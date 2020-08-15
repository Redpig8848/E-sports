<?php

namespace App\Console;

use App\Console\Commands\After;
use App\Console\Commands\AllMatch;
use App\Console\Commands\AllMatchIng;
use App\Console\Commands\AllSchedule;
use App\Console\Commands\ScoreIng;
use App\Console\Commands\ScoreNot;
use App\Console\Commands\ScoreOver;
use App\Console\Commands\Today;
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
        //
        AllMatchIng::class,
        AllMatch::class,
        ScoreNot::class,
        ScoreOver::class,
        ScoreIng::class,
        Today::class,
        After::class,
        AllSchedule::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('command:AllMatchIng')
            ->everyMinute();
        $schedule->command('command:AllMatch')
            ->everyTenMinutes();
        $schedule->command('command:ScoreNot')
            ->everyTenMinutes();
        $schedule->command('command:ScoreOver')
            ->everyTenMinutes();
        $schedule->command('command:ScoreIng')
            ->everyMinute();
        $schedule->command('command:Today')
            ->everyFifteenMinutes();
        $schedule->command('command:After')
            ->daily();
        $schedule->command('command:AllSchedule')
            ->dailyAt('01:00');
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
