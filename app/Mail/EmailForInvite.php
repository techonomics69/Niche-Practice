<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class EmailForInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $viewSubject;

    public $viewFromName;

    public $viewReplyTo;

    public $viewFile;

    public $userId;
    public $templateId;

    /**
     * EmailForQueuing constructor.
     * @param $index
     * @param $view
     */
    public function __construct($templateSubject, $senderBusinessName, $viewReplyTo, $viewFile, $userId, $templateId)
    {
        $this->viewSubject = $templateSubject;
        $this->viewFromName = $senderBusinessName;
        $this->viewReplyTo = $viewReplyTo;
        $this->viewFile = $viewFile;
        $this->userId = $userId;
        $this->templateId = $templateId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info("build " . $this->viewFromName);

        $env = config('apikeys.APP_ENV');
        $fromEmail = config('apikeys.fromEmail');

        if(strtolower($env) == 'production')
        {
            $category = 'patient_template_production';
        }
        else
        {
            $category = 'patient_template_staging';
        }

        $headerData = [
            'category' => $category,
            'unique_args' => [
                'tied_up_with' => 'doctor'.$this->userId.'patient_template'.$this->templateId
            ]
        ];

        $header = $this->asString($headerData);

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', $header);
        });

        if( empty($this->viewReplyTo) )
        {
            return $this->from($fromEmail, $this->viewFromName)
                ->subject($this->viewSubject)
                ->view('email');
        }

        // if from name is empty we're using Practice Name

        return $this->from($fromEmail, $this->viewFromName)
            ->subject($this->viewSubject)->replyTo($this->viewReplyTo)
            ->view('email');
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
