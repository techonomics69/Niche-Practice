<?php

namespace App\Http\Controllers;

use App\Jobs\ScheduleSingleSendCampaign;
use App\Jobs\SendEmail;
use App\Mail\EmailForQueuing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Log;
use Modules\Business\Models\EmailTemplate;

class JobController extends Controller
{
//    public function enqueue(Request $request)
//    {
//        Log::info('process enque');
////        $details = ['email' => 'fsd.ark03@gmail.com'];
////        $email = new EmailForQueuing();
////        Mail::to('fsd.ark03@gmail.com')->send($email);
////        exit;
//
//        $details = [
//            'fsd.ark03@gmail.com',
//            'aaa@gm.com',
//            'baaa@gm.com',
//            'caaa@gm.com',
//            'daaa@gm.com',
//            'eaaa@gm.com',
//            'faaa@gm.com'
//        ];
////            SendEmail::dispatch($details);
//
//        SendEmail::dispatch($details)->onQueue('test');
//
//        Log::info('process enque ending state');
//
//    }

    public function runEmailCampaign($recipientsData)
    {
//        Log::info("runEmailCampaign request ");
//        Log::info("time checker ");
//        Log::info(strtotime(now()->addMinutes(2)));


        SendEmail::dispatch($recipientsData)->onQueue('campaign');
//            ->delay(now()->addMinutes(2));;
    }

    public function runSingleSendCampaign($data)
    {
//        Log::info("runSingleSendCampaign request ");
//        Log::info("time checker ");
//        Log::info(strtotime(now()->addMinutes(2)));

        ScheduleSingleSendCampaign::dispatch($data)->onQueue('singlesend')
            ->delay(now()->addMinutes(10));
    }

}
