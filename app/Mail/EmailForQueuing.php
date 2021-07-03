<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class EmailForQueuing extends Mailable
{
    use Queueable, SerializesModels;

    public $viewSubject;

    public $viewFromName;

    public $viewReplyTo;

    public $viewFile;

    /**
     * EmailForQueuing constructor.
     * @param $index
     * @param $view
     */
    public function __construct($templateSubject, $senderBusinessName, $viewReplyTo, $viewFile)
    {
        $this->viewSubject = $templateSubject;
        $this->viewFromName = $senderBusinessName;
        $this->viewReplyTo = $viewReplyTo;
        $this->viewFile = $viewFile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info("build " . $this->viewFromName);

        $fromEmail = config('apikeys.fromEmail');

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
}
