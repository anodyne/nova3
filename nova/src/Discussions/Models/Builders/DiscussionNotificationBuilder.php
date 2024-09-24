<?php

declare(strict_types=1);

namespace Nova\Discussions\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class DiscussionNotificationBuilder extends Builder
{
    public function discussion(int $discussionId): self
    {
        return $this->where('discussion_id', $discussionId);
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
