<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;
use Log;

class NotifyAdminNewUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $firstName;
    public $lastName;
    public $BusinessName;
    public $Useremail;
    public $registeredAt;
    public $niche;
    public $plan;

    public function __construct($firstName, $lastName, $BusinessName, $userEmail, $registeredAt, $niche, $plan)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->BusinessName = $BusinessName;
        $this->Useremail = $userEmail;
        $this->registeredAt = $registeredAt;
        $this->niche = $niche;
        $this->plan = $plan;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = config('apikeys.fromEmail');

        return $this->view('email.admin-notify-new-user')
            ->subject('New User registration ' . $this->Useremail)
            ->from($fromEmail)
            ->with([
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'Useremail' => $this->Useremail,
                'registeredAt' => $this->registeredAt,
                'BusinessName' => $this->BusinessName,
                'plan' => $this->plan,
                'niche' => $this->niche,
            ]);
    }
}
