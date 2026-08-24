<?php

declare(strict_types=1);

namespace Nova\Announcements\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Users\Models\User;

/**
 * @extends Builder<AnnouncementNotification>
 */
class AnnouncementNotificationBuilder extends Builder
{
    public function announcement(Announcement|int $announcement): self
    {
        return $this->where('announcement_id', $announcement->id ?? $announcement);
    }

    public function read(): self
    {
        return $this->where('is_seen', true);
    }

    public function unread(): self
    {
        return $this->where('is_seen', false);
    }

    public function user(User|int $user): self
    {
        return $this->where('user_id', $user->id ?? $user);
    }
}
