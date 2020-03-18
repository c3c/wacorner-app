<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $msg;
    private $sub;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg,$subject)
    {
        $this->msg = $msg;
        $this->sub = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $msg = $this->msg;
        return $this->view('emails.padrao',compact('msg'))->subject($this->sub);
    }
}
