<?php

declare(strict_types=1);

namespace Nova\PublicSite\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendSiteContactMessage extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $subjectLine,
        public string $message
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(address: $this->email, name: $this->name),
            subject: 'Site contact message - '.$this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.site-contact-message',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
