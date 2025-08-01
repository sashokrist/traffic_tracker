<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VisitReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filepath;

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;
    }

    public function build()
    {
        return $this->subject('Website Visit Report')
            ->markdown('emails.visit_report')
            ->attach(storage_path("app/{$this->filepath}"));
    }
}
