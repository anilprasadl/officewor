<?php

namespace App\Mail;
use App\SiteConstant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class sendBookingMailToAdmin extends Mailable
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
        try
          {
            return $this->view('emails.sendBookingMailToAdmin')
            ->from(SiteConstant::MAIL_FROM)
            ->to(SiteConstant::MAIL_TO)
            ->subject(SiteConstant::SUBJECT_ADMIN_NOTIFICATION)
            ->with(['name' => $this->records['name'],'event_name' => $this->records['event_name'],
            'event_start_date' => $this->records['event_start_date'],'event_end_date' => $this->records['event_end_date']]);
          }catch(\Exception $e){
              Log::error($e->getMessage());
          }
    }
}
