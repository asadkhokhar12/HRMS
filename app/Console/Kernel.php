<?php

namespace App\Console;

use App\Console\Commands\GenerateSalaries;
use App\Console\Commands\CalculateSalaries;
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
        GenerateSalaries::class,
        CalculateSalaries::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('salary:generate')
            ->monthlyOn(1, '00:00') // Run on the first of every month at midnight
            ->sendOutputTo(storage_path('logs/salary_generate.log')); // Log output to this file

        $schedule->command('salary:calculate')
            ->dailyAt('12:10')
            ->sendOutputTo(storage_path('logs/salary_calculate.log'));

        // $schedule->command('inspire')->hourly();
        $schedule->command('auto:checkout')->daily();

        // expire notification
        $schedule->command('notification:expire')->dailyAt('00:00');

        // $schedule->command('queue:work --stop-when-empty')
        //         ->everyFiveMinutes()
        //          ->withoutOverlapping();

        $schedule->command('queue:work --timeout=0 --stop-when-empty')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
