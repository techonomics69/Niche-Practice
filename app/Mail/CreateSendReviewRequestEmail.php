<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Config;
use Modules\Business\Models\Business;

class CreateSendReviewRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tries = 1;

    public $timeout = 60;

    protected $email;
    protected $varificationCode;
    protected $businessId;
    protected $reviewId;

    protected $firstName;

    protected $lastName;

    protected $emailMessage;

    protected $formatedBusinessName;

    protected $BusinessName;

    protected $redirectLink;

    protected $userId;

    protected $thumbupimg;

    protected $thumbdownimg;

    protected $logoimg;

    protected $practice_name;

    protected $logo;

    protected $logosrc;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName, $formatedBusinessName, $BusinessName, $varificationCode, $email, $userEmail, $emailMessage, $businessId, $reviewId, $userID = '', $practice_name, $logo, $lastName = '' )
    {
        Log::info('at testing email section');
        // $url = 'https://staging.nichepractice.com';
//        $url = config('app.url', 'https://staging.nichepractice.com');
        $url = url('/');

//        Log::info('Mail url');
//        Log::info($url);
//
//        Log::info('Mail Other url');
//        Log::info(url('/'));

        $thumbupimg = $url.'/public/images/feedback-review/like.png';
        $thumbdownimg = $url.'/public/images/feedback-review/dislike.png';
        $logoimg = $url.'/public/images/logo-register.png';
        $logosrc = $url.'/storage/app/'.$logo;
        $this->email = $email;
        $this->varificationCode = $varificationCode;
        $this->businessId = $businessId;
        $this->reviewId = $reviewId;

        $this->thumbupimg = $thumbupimg;
        $this->thumbdownimg = $thumbdownimg;
        $this->logoimg = $logoimg;

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->BusinessName = $BusinessName;
        $this->emailMessage = $emailMessage;
        $this->formatedBusinessName = $formatedBusinessName;

        $this->userId = $userID;
        $this->practice_name = $practice_name;
        $this->logo = $logo;
        $this->logosrc = $logosrc;
        $url .= '/business-review/' . $email . '/' . $varificationCode . '/' . $businessId . '/' . $reviewId;
        Log::info('check formated business');
        Log::info($formatedBusinessName);
        Log::info($BusinessName);
        Log::info($url);


        $this->redirectLink = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $env = config('apikeys.APP_ENV');
        $fromEmail = config::get('apikeys.fromEmail');

        if(strtolower($env) == 'production')
        {
            $category = 'review_production';
        }
        else
        {
            $category = 'review_staging';
        }

        $headerData = [
            'category' => $category,
            'unique_args' => [
                'tied_up_with' => 'doctor'.$this->userId.'review'
            ]
        ];

        $header = $this->asString($headerData);

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', $header);
        });


        return $this->view('email.user.test')
            ->subject('Your Experience with ' . $this->BusinessName)
//            ->from('noreply@' . $this->formatedBusinessName . '.com')
            ->from($fromEmail, $this->BusinessName)
            ->with(
                [
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'BusinessName' => $this->BusinessName,
                'redirectLink' => $this->redirectLink,
                'emailMessage' => $this->emailMessage,
                'thumbupimg' => $this->thumbupimg,
                'thumbdownimg' => $this->thumbdownimg,
                'logoimg' => $this->logoimg,
                'email' => $this->email,
                'varificationCode' => $this->varificationCode,
                'businessId' => $this->businessId,
                'reviewId' => $this->reviewId,
                'practice_name' => $this->practice_name,
                'logo' => $this->logo,
                'logosrc' => $this->logosrc
            ]);

    }

    private function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

        return $json;
    }


    private function asString($data)
    {
        $json = $this->asJSON($data);

        return wordwrap($json, 76, "\n   ");
    }
}
