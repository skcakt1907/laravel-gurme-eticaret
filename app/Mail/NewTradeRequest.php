<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Restoran / toptan alım talebi geldiğinde yöneticiye giden bildirim.
 */
class NewTradeRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yeni Teklif Talebi: '.$this->appointment->name,
            replyTo: $this->appointment->email ? [$this->appointment->email] : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.trade-request',
        );
    }
}
