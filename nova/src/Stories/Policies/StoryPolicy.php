<?php

declare(strict_types=1);

namespace Nova\Stories\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class StoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAbleTo('story.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Story $story)
    {
        return $user->isAbleTo('story.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('story.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Story $story)
    {
        return $user->isAbleTo('story.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Story $story)
    {
        return $user->isAbleTo('story.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function duplicate(User $user, Story $story)
    {
        return $user->isAbleTo('story.create') && $user->isAbleTo('story.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Story $story)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Story $story)
    {
        return $this->denyWithStatus(418);
    }
}
