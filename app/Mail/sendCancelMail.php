<?php

namespace App\Mail;

use App\SiteConstant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class sendCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($records)
    {
        $this->records=$records;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sendCancelMail')
        ->from(SiteConstant::MAIL_FROM)
        ->to($this->records['email'])
        ->subject(SiteConstant::SUBJECT_NOTIFICATION)
        ->with(['name' => $this->records['name'],'event_name' => $this->records['event_name'],'event_start_date' => $this->records['event_start_date']]);
    }
}
