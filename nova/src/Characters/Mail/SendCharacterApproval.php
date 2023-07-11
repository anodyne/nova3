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

class SendCharacterApproval extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Character $character
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New character approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.characters.character-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
