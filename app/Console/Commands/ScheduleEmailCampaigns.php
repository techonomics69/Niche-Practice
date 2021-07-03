<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Modules\Business\Entities\CampaignEntity;
use Modules\Business\Http\Controllers\BusinessController;

class ScheduleEmailCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commander:schedule-campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will schedule email campaigns';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("yes I'm called");
//        \Log::info(Inspiring::quote());

        $campaignObj = new CampaignEntity();
        $campaignObj->scheduleEmailCampaign();
    }
}
