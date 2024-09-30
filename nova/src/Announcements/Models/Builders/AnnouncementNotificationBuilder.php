<?php

declare(strict_types=1);

namespace Nova\Announcements\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class AnnouncementNotificationBuilder extends Builder
{
    public function announcement(int $announcementId): self
    {
        return $this->where('announcement_id', $announcementId);
    }

    public function unread(): self
    {
        return $this->where('is_seen', false);
    }

    public function user(int $userId): self
    {
        return $this->where('user_id', $userId);
    }
}
