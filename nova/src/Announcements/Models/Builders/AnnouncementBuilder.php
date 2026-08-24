<?php

declare(strict_types=1);

namespace Nova\Announcements\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Users\Models\User;

/**
 * @extends Builder<Announcement>
 */
class AnnouncementBuilder extends Builder
{
    public function draft(): self
    {
        return $this->where('status', PublishStatus::Draft);
    }

    public function pending(): self
    {
        return $this->where('status', PublishStatus::Pending);
    }

    public function published(): self
    {
        return $this->where('status', PublishStatus::Published);
    }

    public function searchFor(string $search): self
    {
        return $this->where(function ($query) use ($search): void {
            $query->whereFullText('title', $search)
                ->orWhereLike('title', "%{$search}%");
        });
    }

    public function uniqueCategories(): self
    {
        return $this->select('category')->whereNotNull('category')->distinct();
    }

    public function withReadNotificationsForUser(User $user): self
    {
        return $this->whereHas('notifications', function (Builder $query) use ($user): void {
            /** @var AnnouncementNotificationBuilder $announcementNotificationQuery */
            $announcementNotificationQuery = $query;

            $announcementNotificationQuery->user($user->id)->read();
        });
    }

    public function withUnreadNotificationsForUser(User $user): self
    {
        return $this->whereHas('notifications', function (Builder $query) use ($user): void {
            /** @var AnnouncementNotificationBuilder $announcementNotificationQuery */
            $announcementNotificationQuery = $query;

            $announcementNotificationQuery->user($user->id)->unread();
        });
    }
}
