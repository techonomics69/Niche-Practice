<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;
use Log;

class NotificationSendToReferer extends Mailable
{
    use Queueable, SerializesModels;
    public $referalEmail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($referalEmail)
    {
        //
        $this->referalEmail = $referalEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = config('apikeys.fromEmail');
        return $this->view('email.mail-to-referer')
        ->subject('New Referal Registration ' . $this->referalEmail)
        ->from($fromEmail)
        ->with([
            'email' => $this->referalEmail,
        ]);
    }
}
