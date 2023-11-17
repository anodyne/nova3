<?php

declare(strict_types=1);

namespace Nova\Stories\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class StoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('story.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Story $story): Response
    {
        return $user->isAbleTo('story.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('story.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Story $story): Response
    {
        return $user->isAbleTo('story.update')
            ? $this->allow()
            : $this->deny();
    }

    public function updateDates(User $user, Story $story): Response
    {
        return $this->update($user, $story)->allowed() && $story->is_completed
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Story $story): Response
    {
        return $user->isAbleTo('story.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(User $user, Story $story): Response
    {
        return $user->isAbleTo('story.create') && $user->isAbleTo('story.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Story $story): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Story $story): Response
    {
        return $this->denyWithStatus(418);
    }
}
