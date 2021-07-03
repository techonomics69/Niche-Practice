<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;
use Log;

class NotifyNewReview extends Mailable
{
    use Queueable, SerializesModels;

    protected $firstName;

    protected $companyName;

    protected $message;

    protected $subjectTitle;

    protected $notifyType;

    protected $niche;

    protected $industry;

    protected $rating;

    public function __construct($firstName, $companyName, $message, $subject, $notifyType, $niche, $industry, $rating)
    {
        //
        $this->firstName = $firstName;
        $this->companyName = $companyName;
        $this->message = $message;
        $this->subjectTitle = $subject;
        $this->notifyType = $notifyType;
        $this->niche = $niche;
        $this->industry = $industry;
        $this->rating = $rating;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = config('apikeys.fromEmail');

        return $this->view('email.notify-new-review')
//            ->subject('Check out nichepractice - a powerful new marketing tool')
            ->subject($this->subjectTitle)
            ->from($fromEmail)
            ->with('firstName', $this->firstName)
            ->with('companyName', $this->companyName)
            ->with('messages', $this->message)
            ->with('niche', $this->niche)
            ->with('industry', $this->industry)
            ->with('rating', $this->rating)
//            ->with('subjects', $this->subjects)
            ->with('notifyType', $this->notifyType);
    }
}
