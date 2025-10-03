<?php

declare(strict_types=1);

namespace Nova\Announcements\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Users\Models\User;

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

    public function searchFor($search): self
    {
        return $this->whereFullText('title', $search.'*', ['mode' => 'boolean']);
    }

    public function uniqueCategories(): self
    {
        return $this->select('category')->whereNotNull('category')->distinct();
    }

    public function withReadNotificationsForUser(User $user): self
    {
        return $this->whereHas(
            'notifications',
            fn (Builder $query): Builder => $query->whereUser($user->id)->read()
        );
    }

    public function withUnreadNotificationsForUser(User $user): self
    {
        return $this->whereHas(
            'notifications',
            fn (Builder $query): Builder => $query->whereUser($user->id)->unread()
        );
    }
}
