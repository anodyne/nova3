<?php

declare(strict_types=1);

namespace Nova\Posts\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Characters\Models\Character;
use Nova\Posts\Models\Post;

class SendCharacterAuthorAddedToPost extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Post $post,
        public Character $character
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'One of your characters has been added to a post',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.posts.character-author-added',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
