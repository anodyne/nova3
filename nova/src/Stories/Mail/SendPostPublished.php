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

class SendPostPublished extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Post $post
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New post published - '.$this->post->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.post-published',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
