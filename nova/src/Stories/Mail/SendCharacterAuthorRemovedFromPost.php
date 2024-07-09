<?php

declare(strict_types=1);

namespace Nova\Stories\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Characters\Models\Character;
use Nova\Stories\Models\Post;

class SendCharacterAuthorRemovedFromPost extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Post $post,
        public Character $character
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Character removed as author from a post',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.character-author-removed-from-post',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
