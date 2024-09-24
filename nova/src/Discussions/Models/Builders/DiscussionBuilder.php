<?php

declare(strict_types=1);

namespace Nova\Discussions\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DiscussionBuilder extends Builder
{
    public function conversation(): self
    {
        return $this->whereNull(['discussable_type', 'discussable_id']);
    }

    public function directMessage(): self
    {
        return $this->where('is_direct_message', true);
    }

    public function groupMessage(): self
    {
        return $this->where('is_direct_message', false);
    }

    public function forCurrentUser(): self
    {
        return $this->withWhereHas('allParticipants', function ($query) {
            $query->whereNull('discussion_participant.deleted_at')
                ->where('users.id', Auth::id());
        });
        // return $this->whereRelation('allParticipants', 'users.id', '=', Auth::id());
    }

    public function withoutCurrentUser(): self
    {
        return $this->whereRelation('allParticipants', 'users.id', '=', Auth::id());
    }
}
