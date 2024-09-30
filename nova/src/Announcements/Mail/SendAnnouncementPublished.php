<?php

declare(strict_types=1);

namespace Nova\Announcements\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Nova\Announcements\Models\Announcement;

class SendAnnouncementPublished extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Announcement $announcement
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New announcement published - '.$this->announcement->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.announcement-published',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
