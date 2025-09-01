<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KunjunganStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $kunjungan;

    /**
     * Create a new message instance.
     */
    public function __construct(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Pengajuan Kunjungan Anda',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.kunjungan-status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}