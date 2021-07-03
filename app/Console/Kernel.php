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
        'App\Console\Commands\ScheduleEmailCampaigns',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        \Log::info(env('APP_ENV'));
//        \Log::info(config('apikeys.APP_ENV'));
//        \Log::info("fromEmail");
//        \Log::info(config('apikeys.fromEmail'));

        if(config('apikeys.APP_ENV') == 'production')
        {
            \Log::info("cronjob run");
            $schedule->command('commander:schedule-reviews')->dailyAt('04:30');
            $schedule->command('commander:schedule-campaigns')->everyTenMinutes();
            $schedule->command('commander:schedule-reviews')->dailyAt('17:25');
        }

//         $schedule->command('inspire')->everyMinute();
//         $schedule->command('inspire')->everyFiveMinutes();
//         $schedule->command('commander:send-email')->everyMinute();
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
