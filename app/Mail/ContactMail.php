<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Business\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $contact;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        //
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $baseurl = config('app.url');

//        $baseurl = 'https://app.nichepractice.com/';

        $current_user_email = session('user_data')['email'];
        return $this->from($current_user_email)->view('layouts.contactmail')->with([
            'comment' => $this->contact->comment,
            'feedback_option' => $this->contact->feedback_option,
            'attachment' => $this->contact->attachment,
            'baseurl' => $baseurl
        ]);
        // ->attachFromStorage($baseurl.'public/storage/'.$this->contact->attachment)
    }
}
