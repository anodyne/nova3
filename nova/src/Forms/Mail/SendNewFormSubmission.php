<?php

declare(strict_types=1);

namespace Nova\Forms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Users\Models\User;

class SendNewFormSubmission extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public ?User $user,
        public array $values,
        public string $form
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf('New form submission (%s)', $this->form),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.forms.new-form-submission',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
