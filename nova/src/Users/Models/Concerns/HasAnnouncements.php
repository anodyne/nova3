<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;

trait HasAnnouncements
{
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function announcementNotifications(): HasMany
    {
        return $this->hasMany(AnnouncementNotification::class);
    }

    public function unreadAnnouncementsCount(): Attribute
    {
        return new Attribute(
            get: fn (): int => once(fn () => AnnouncementNotification::query()->user($this->id)->unread()->count()),
        );
    }
}
