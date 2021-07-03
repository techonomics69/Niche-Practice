<?php

namespace App\Jobs;

use App\Mail\EmailForQueuing;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Exception;
use Log;
use Modules\Business\Entities\CampaignEntity;
use Modules\Business\Models\CampaignUsersTrack;
use Modules\Business\Models\EmailTemplate;
use Modules\CRM\Models\Recipient;

class ScheduleSingleSendCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public $timeout = 480;


    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        Log::info("process begin");

        try {
            if(empty($this->details['job_id']) || empty($this->details['single_send_id']))
            {
                $missing = 'both';
                if(empty($this->details['single_send_id']))
                {
                    $missing .= ' single_send_id';
                }

                if(empty($this->details['job_id']))
                {
                    $missing .= ' job_id';
                }

                $this->fail("missing paramters $missing");
                Log::info("process Fterfail");

                return false;
            }

            $jobId = $this->details['job_id'];
            $campaignObj = new CampaignEntity();

            $currentJobStatus = $campaignObj->checkCurrentJobStatus($jobId);

            if ($currentJobStatus['_metadata']['outcomeCode'] != 200) {
                $message = $currentJobStatus['_metadata']['message'];
                $this->fail("checkCurrentJobStatus exception found > $message");
                Log::info("process Fterfail2");

                return false;
            }

            if($currentJobStatus['records']['status'] == 'completed')
            {
                $currentScheduleStatus = $campaignObj->scheduleSingleSend(['single_send_id' => $this->details['single_send_id']]);

                if($currentScheduleStatus['_metadata']['outcomeCode'] != 200)
                {
                    $message = $currentScheduleStatus['_metadata']['message'];
                    $this->fail("currentScheduleStatus exception found > $message");
                    Log::info("process Fterfail3");

                    return false;
                }
                else
                {
                    if(!empty($this->details['template_id']))
                    {
                        EmailTemplate::where('id', $this->details['template_id'])->update(
                            [
                                'template_status' => 'published'
                            ]
                        );
                    }
                }
            }

//            $campaignObj->scheduleSingleSend(['job_id' => 'ab']);

//            $error = 'Always throw this error';

//            fail(Throwable);
//            $this->fail("testing the failure");

//            Log::info("time checker inside fail");
//            Log::info(strtotime(now()->addMinutes(2)));
//
//            $timeD = strtotime(now()->addMinutes(2));
//            $this->release($timeD);

//            $this->release();
//            throw new Exception($error);
//
//            Log::info("process Fterfail");
        }catch(\Exception $e)
        {
            Log::info("Exception");
        }

        Log::info("process END");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
//    public function handle()
//    {
//        Log::info("process begin");
//
//        Log::info("process END");
//
//        $templatePreview = $this->details['template_preview'];
//        $templateID = $this->details['id'];
//        $templateSubject = $this->details['subject'];
//        $senderBusinessName = $this->details['fromBusinessName'];
//        $replyTo = $this->details['reply_email'];
//
//        Log::info("pre  $templateID > $templateSubject > $senderBusinessName > $replyTo");
////        Log::info($templateSubject);
//        foreach ($this->details['campaign_users_linked'] as $index => $recipient)
//        {
//            try
//            {
//                Log::info("recu > " . $templateSubject);
////                Log::info($recipient);
//                if(!empty($recipient['recipients']))
//                {
//                    $campaignTemplateId = $recipient['id'];
//                    $recipientData = $recipient['recipients'];
//                    $recipientEmail = $recipientData['email'];
//                    $userId = $recipientData['user_id'];
//
//                    Log::info("go ahead > ( $recipientEmail ) ( user > $userId ) ( templateID > $templateID )");
////                    $email = new EmailForQueuing($templatePreview);
//                    $email = new EmailForQueuing($templateSubject, $senderBusinessName, $replyTo, $templatePreview);
//                    Mail::to($recipientEmail)->send($email);
//
//                    if (Mail::failures()) {
//                        Log::info('email failed');
//                    }else{
//                        Log::info('success email');
//                        $date = date("Y-m-d H:i:s");
//                        CampaignUsersTrack::where('id', $campaignTemplateId)->where('user_id', $userId)
//                            ->update(
//                                [
//                                    'sending_status' => $date
//                                ]
//                            );
//                    }
//
//                    sleep(5);
//                }
//            }
//            catch (Exception $e)
//            {
//                Log::info("SendEmail >");
//                Log::info($e->getMessage() . ' > ' . $e->getMessage());
//            }
//        }
//
//
//
//        Log::info("process finished");
////        try
////        {
////
//////            dd($this->details['email']);
////        }
////        catch (Exception $e)
////        {
////            dd($e->getMessage());
////        }
//    }
}
