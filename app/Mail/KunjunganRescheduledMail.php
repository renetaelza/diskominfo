<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KunjunganRescheduledMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $kunjungan;
    public $oldDate;
    public $oldTime;

    /**
     * Create a new message instance.
     */
    public function __construct(Kunjungan $kunjungan, $oldDate, $oldTime)
    {
        $this->kunjungan = $kunjungan;
        $this->oldDate = $oldDate;
        $this->oldTime = $oldTime;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Penjadwalan Ulang Kunjungan Anda',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.kunjungan-rescheduled',
        );
    }
}