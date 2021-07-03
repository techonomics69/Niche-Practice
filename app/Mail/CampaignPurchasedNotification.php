<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;
use Log;

class CampaignPurchasedNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $firstName;

    protected $lastName;

    protected $campaignName;

    protected $campaignCredits;

    protected $remainingCredits;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName, $lastName, $campaignName, $campaignCredits, $remainingCredits)
    {
        //
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->campaignName = $campaignName;
        $this->campaignCredits = $campaignCredits;
        $this->remainingCredits = $remainingCredits;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = config('apikeys.fromEmail');

        return $this->view('email.campaign-unlock-notification')
            ->subject('You just purchased a campaign')
            ->from($fromEmail)
            ->with('firstName', $this->firstName)
            ->with('lastName', $this->lastName)
            ->with('campaignName', $this->campaignName)
            ->with('campaignCredits', $this->campaignCredits)
            ->with('remainingCredits', $this->remainingCredits);
    }
}
