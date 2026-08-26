<?php

declare(strict_types=1);

namespace Nova\Discussions\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Discussions\Models\DiscussionNotification;

/**
 * @extends Builder<DiscussionNotification>
 */
class DiscussionNotificationBuilder extends Builder
{
    public function discussion(string $discussionId): self
    {
        return $this->where('discussion_id', $discussionId);
    }

    public function unread(): self
    {
        return $this->where('is_seen', false);
    }

    public function user(string $userId): self
    {
        return $this->where('user_id', $userId);
    }
}
