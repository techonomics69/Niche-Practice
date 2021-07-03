<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;
use Log;

class CreateAddRecipientsEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $firstName;
    public $BusinessName;
    public $formatedBusinessName;
    public $redirectLink;
    public $Useremail;
    public $emailMessage;

    public function __construct($firstName, $formatedBusinessName, $BusinessName, $varificationCode, $email, $userEmail, $emailMessage, $businessId, $reviewId)
    {
        Log::info('in email section check server');
        Log::info(getDomain());
        $url = getDomain();

        $this->firstName = $firstName;
        $this->BusinessName = $BusinessName;
        $this->emailMessage = $emailMessage;
        $this->formatedBusinessName = $formatedBusinessName;
        $url .= '/business-review/' . $email . '/' . $varificationCode . '/' . $businessId . '/' . $reviewId;

        $this->redirectLink = $url;
        $this->Useremail = $userEmail;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.user.addRecipientsEmail')
            ->subject('Your Experience with ' . $this->BusinessName)
            ->from('noreply@' . $this->formatedBusinessName . '.com')
            ->with([
                'firstName' => $this->firstName,
                'BusinessName' => $this->BusinessName,
                'redirectLink' => $this->redirectLink,
                'emailMessage' => $this->emailMessage,
            ]);
    }
}
