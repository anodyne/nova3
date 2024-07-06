<?php

declare(strict_types=1);

namespace Nova\Characters\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Characters\Models\Character;

class SendCharacterDenial extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Character $character
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New character denied',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pending-character-denied',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
