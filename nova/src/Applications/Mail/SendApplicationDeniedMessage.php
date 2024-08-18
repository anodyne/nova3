<?php

declare(strict_types=1);

namespace Nova\Applications\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Applications\Models\Application;

class SendApplicationDeniedMessage extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Application $application
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your application has been denied',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-denied',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
