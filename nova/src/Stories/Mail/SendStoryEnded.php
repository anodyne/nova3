<?php

declare(strict_types=1);

namespace Nova\Stories\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Stories\Models\Story;

class SendStoryEnded extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Story $story
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Running story has ended',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.stories.story-ended',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
