<?php

declare(strict_types=1);

namespace Nova\Stories\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Stories\Models\Post;

class SendPostDraftDiscarded extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Post $post
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Draft post has been discarded',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.posts.draft-post-discarded',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
