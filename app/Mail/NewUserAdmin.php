<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Yeni üye kaydolduğunda yöneticiye giden bildirim.
 */
class NewUserAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yeni Üye Kaydı: '.$this->user->name,
            replyTo: [$this->user->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-user',
        );
    }
}
