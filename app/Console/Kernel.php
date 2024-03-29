<?php

namespace App\Console;

use App\Actions\Crontab;
use App\Actions\ScheduleSms;
use App\Actions\SmsGetStatus;
use App\Actions\SmsGetStatusSchedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(new SmsGetStatus())->everyMinute();

        //$schedule->call(new ScheduleSms())->everyMinute();

        $schedule->call(new Crontab())->everyMinute();

        //$schedule->call(new SmsGetStatusSchedule())->everyMinute();



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
