<?php

declare(strict_types=1);

namespace Nova\Posts\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Posts\Models\Post;

class SendUserAuthorAddedToPost extends Mailable implements ShouldQueue
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
            subject: 'Your user account has been added to a post',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.posts.user-author-added',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
