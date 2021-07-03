<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Business\Models\Referalemail;

class ReferalMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $referalemail;

    protected $businessName;

    /**
     *
     * ReferalMail constructor.
     * @param Referalemail $referalemail
     * @param $businessName
     */
    public function __construct($referalemail, $businessName)
    {
        //
        $this->referalemail = $referalemail;
        $this->businessName = $businessName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $current_user_email = session('user_data')['email'];
        $current_user_first_name = session('user_data')['first_name'];
        $current_id = base64_encode(session('user_data')['id']);
        $baseurl = url('/');
        return $this->from($current_user_email, $this->businessName)
            ->subject('Check out nichepractice - a powerful new marketing tool')
            ->view('layouts.referalemail')
            ->with('current_user_first_name', $current_user_first_name)
            ->with('current_user_email', $current_user_email)
            ->with('baseurl', $baseurl)
            ->with('u_id', $current_id)
            ->with('referalemail', $this->referalemail);
    }
}
