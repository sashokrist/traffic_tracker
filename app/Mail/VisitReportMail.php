<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

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
            ->attach(Storage::path($this->filepath), [
                'as' => basename($this->filepath),
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
