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
use Modules\Business\Models\CampaignUsersTrack;
use Modules\CRM\Models\Recipient;

class SendEmail implements ShouldQueue
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("process begin");

        $templatePreview = $this->details['template_preview'];
        $templateID = $this->details['id'];
        $templateSubject = $this->details['subject'];
        $senderBusinessName = $this->details['fromBusinessName'];
        $replyTo = $this->details['reply_email'];

        Log::info("pre  $templateID > $templateSubject > $senderBusinessName > $replyTo");
//        Log::info($templateSubject);
        foreach ($this->details['campaign_users_linked'] as $index => $recipient)
        {
            try
            {
                Log::info("recu > " . $templateSubject);
//                Log::info($recipient);
                if(!empty($recipient['recipients']))
                {
                    $campaignTemplateId = $recipient['id'];
                    $recipientData = $recipient['recipients'];
                    $recipientEmail = $recipientData['email'];
                    $userId = $recipientData['user_id'];

                    Log::info("go ahead > ( $recipientEmail ) ( user > $userId ) ( templateID > $templateID )");
//                    $email = new EmailForQueuing($templatePreview);
                    $email = new EmailForQueuing($templateSubject, $senderBusinessName, $replyTo, $templatePreview);
                    Mail::to($recipientEmail)->send($email);

                    if (Mail::failures()) {
                        Log::info('email failed');
                    }else{
                        Log::info('success email');
                        $date = date("Y-m-d H:i:s");
                        CampaignUsersTrack::where('id', $campaignTemplateId)->where('user_id', $userId)
                            ->update(
                                [
                                    'sending_status' => $date
                                ]
                            );
                    }

                    sleep(5);
                }
            }
            catch (Exception $e)
            {
                Log::info("SendEmail >");
                Log::info($e->getMessage() . ' > ' . $e->getMessage());
            }
        }



        Log::info("process finished");
//        try
//        {
//
////            dd($this->details['email']);
//        }
//        catch (Exception $e)
//        {
//            dd($e->getMessage());
//        }
    }
}