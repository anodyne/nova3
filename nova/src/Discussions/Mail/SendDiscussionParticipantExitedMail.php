<?php

declare(strict_types=1);

namespace Nova\Discussions\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Discussions\Models\Discussion;
use Nova\Users\Models\User;

class SendDiscussionParticipantExitedMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Discussion $discussion,
        public User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Discussion participant exited',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.discussion-participant-exited',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
