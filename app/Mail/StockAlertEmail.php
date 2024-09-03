<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockAlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $supplier;

    public function __construct($subject, $message, $supplier) {
        $this->subject = $subject;
        $this->message = $message;
        $this->supplier = $supplier;
    }

    public function build()
    {
        return $this->view('admin.emails.stock_alert')
            ->subject($this->subject)
            ->with([
                'alertMessage' => $this->message,
                'supplier' => $this->supplier,
            ]);
    }

}
