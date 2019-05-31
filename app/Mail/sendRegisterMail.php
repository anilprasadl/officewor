<?php

namespace App\Mail;
use App\SiteConstant;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;


class sendRegisterMail extends Mailable
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
        //   print_r($this->records['name']);exit;
          return $this->view('emails.sendRegisterMail')
          ->from(SiteConstant::MAIL_FROM)
          ->to($this->records['email'])
          ->subject(SiteConstant::SUBJECT_REGISTRATION)
          ->with(['name' => $this->records['name'],'email'=>$this->records['email']]);
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }
}
