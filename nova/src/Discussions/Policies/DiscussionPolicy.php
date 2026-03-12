<?php

declare(strict_types=1);

namespace Nova\Discussions\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
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
            : $this->denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $this->allow();
    }

    public function update(User $user, Discussion $discussion): Response
    {
        return $this->isParticipant($discussion, $user)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Discussion $discussion): Response
    {
        return $this->isParticipant($discussion, $user)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function deleteMessage(User $user, Discussion $discussion, DiscussionMessage $message): Response
    {
        if ($this->delete(user: $user, discussion: $discussion)->allowed()) {
            return $message->discussion_id === $discussion->id
                ? $this->allow()
                : $this->denyAsNotFound();
        }

        return $this->denyAsNotFound();
    }

    public function duplicate(User $user, Discussion $discussion): Response
    {
        return $this->denyAsNotFound();
    }

    public function restore(User $user, Discussion $discussion): Response
    {
        return $this->denyAsNotFound();
    }

    public function forceDelete(User $user, Discussion $discussion): Response
    {
        return $this->denyAsNotFound();
    }

    public function leave(User $user, Discussion $discussion): Response
    {
        return $this->isParticipant($discussion, $user) && $discussion->is_group_message
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function reply(User $user, Discussion $discussion): Response
    {
        return $this->isParticipant($discussion, $user)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    protected function isParticipant(Discussion $discussion, User $user): bool
    {
        return $discussion->allParticipants->contains('id', $user->id);
    }
}
