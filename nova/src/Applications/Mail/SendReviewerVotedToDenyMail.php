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
use Nova\Applications\Models\ApplicationReview;
use Nova\Users\Models\User;

class SendReviewerVotedToDenyMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Application $application,
        public User $reviewer,
        public ApplicationReview $review
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application reviewer voted to deny',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-reviewer-voted-to-deny',
        );
    }
}
