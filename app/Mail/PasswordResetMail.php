<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        //
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->email;
        $token = $this->token;
        $url = route('password.reset', ['token' => $token]);
        return $this->view('password.reset')->with('email', $email)->with('token', $token)->with('url', $url);
    }
}
