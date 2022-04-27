<?php

namespace App\Console;

use App\Console\Commands\RemindCreateStore;
use App\Console\Commands\RemindEmail;
use App\Console\Commands\WelcomeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commnands = [
        WelcomeCommand::class,
        RemindEmail::class,
        RemindCreateStore::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('welcome:mail')->daily()->withoutOverlapping();
        $schedule->command('mail:remind')->daily()->withoutOverlapping();
        $schedule->command('store:remind')->daily()->withoutOverlapping();
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
