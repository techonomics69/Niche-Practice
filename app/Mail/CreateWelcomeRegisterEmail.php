<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;


class CreateWelcomeRegisterEmail extends Mailable

{
    use Queueable, SerializesModels;
    private $firstName;
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName, $email)
    {
        $this->firstName = $firstName;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = config::get('apikeys.fromEmail');

        return $this->view('email.welcomemail')
            ->subject('Welcome on the Board')
            ->from($fromEmail, 'NichePractice')
            ->with([
                'firstName' => $this->firstName,
                'email' => $this->email,
                //       'link' => 'https://mailtrap.io/inboxes'
            ]);
    }

}
