<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TranscriptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $studentName;

    public function __construct($pdf, $studentName)
    {
        $this->pdf = $pdf;
        $this->studentName = $studentName;
    }

    public function build()
    {
        return $this->subject('Sistema Académico UCA - ' . $this->studentName)
                    ->view('emails.transcript_body')
                    ->attachData($this->pdf->output(), 'transcript.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
