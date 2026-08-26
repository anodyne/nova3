<?php

declare(strict_types=1);

namespace Nova\Discussions\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Discussions\Models\DiscussionParticipant;

/**
 * @extends Builder<DiscussionParticipant>
 */
class DiscussionParticipantBuilder extends Builder
{
    public function discussion(string $discussionId): self
    {
        return $this->where('discussion_id', $discussionId);
    }

    public function user(string $userId): self
    {
        return $this->where('user_id', $userId);
    }
}
