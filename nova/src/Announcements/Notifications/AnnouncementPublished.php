<?php

declare(strict_types=1);

namespace Nova\Announcements\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Announcements\Mail\SendAnnouncementPublished;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Notifications\PreferenceBasedNotification;

class AnnouncementPublished extends PreferenceBasedNotification
{
    protected string $key = 'announcement-published';

    public function __construct(
        protected Announcement $announcement
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'announcement_id' => $this->announcement->id,
            'announcement_title' => $this->announcement->title,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendAnnouncementPublished(
            announcement: $this->announcement
        );
    }
}
