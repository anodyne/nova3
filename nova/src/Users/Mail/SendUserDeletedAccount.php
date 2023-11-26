<?php

declare(strict_types=1);

namespace Nova\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Users\Models\User;

class SendUserDeletedAccount extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public User $user
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User deleted their account',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.users.user-deleted-account',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
