<?php

declare(strict_types=1);

namespace Nova\Discussions\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Discussions\Models\DiscussionParticipant;
use Nova\Users\Models\User;

/**
 * @extends Builder<Discussion>
 */
class DiscussionBuilder extends Builder
{
    public function conversation(): self
    {
        return $this->whereNull(['discussable_type', 'discussable_id']);
    }

    public function directMessage(): self
    {
        return $this->whereHas(relation: 'allParticipants', operator: '=', count: 2);
    }

    public function forCurrentUser(): self
    {
        return $this->withWhereHas('allParticipants', function ($query): void {
            $query->whereNull(DiscussionParticipant::column('deleted_at'))
                ->where(User::column('id'), Auth::id());
        });
    }

    public function groupMessage(): self
    {
        return $this->whereHas(relation: 'allParticipants', operator: '>', count: 2);
    }

    public function searchFor(string $search): self
    {
        return $this
            ->where(Discussion::column('subject'), 'like', "%{$search}%")
            ->orWhereRelation('messages', DiscussionMessage::column('content'), 'like', "%{$search}%")
            ->orWhereRelation('participants', User::column('name'), 'like', "%{$search}%");
    }

    public function withoutCurrentUser(): self
    {
        return $this->whereRelation('allParticipants', User::column('id'), '=', Auth::id());
    }
}
