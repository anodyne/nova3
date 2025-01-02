<?php

declare(strict_types=1);

namespace Nova\Discussions\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Discussions\Models\Discussion;
use Nova\Users\Models\User;

class DiscussionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $this->allow();
    }

    public function view(User $user, Discussion $discussion): Response
    {
        return $this->isParticipant($discussion, $user)
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $this->allow();
    }

    public function update(User $user, Discussion $discussion): Response
    {
        return $this->denyWithStatus(418);
    }

    public function delete(User $user, Discussion $discussion): Response
    {
        return $this->isParticipant($discussion, $user)
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(User $user, Discussion $discussion): Response
    {
        return $this->denyWithStatus(418);
    }

    public function restore(User $user, Discussion $discussion): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Discussion $discussion): Response
    {
        return $this->denyWithStatus(418);
    }

    public function leave(User $user, Discussion $discussion): Response
    {
        return $this->isParticipant($discussion, $user) && $discussion->is_group_message
            ? $this->allow()
            : $this->deny();
    }

    protected function isParticipant(Discussion $discussion, User $user): bool
    {
        return $discussion->allParticipants->contains('id', $user->id);
    }
}
