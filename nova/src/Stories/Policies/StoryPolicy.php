<?php

declare(strict_types=1);

namespace Nova\Stories\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class StoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('story.*');
    }

    public function view(User $user, Story $story): bool
    {
        return $user->isAbleTo('story.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('story.create');
    }

    public function update(User $user, Story $story): bool
    {
        return $user->isAbleTo('story.update');
    }

    public function delete(User $user, Story $story): bool
    {
        return $user->isAbleTo('story.delete');
    }

    public function duplicate(User $user, Story $story): bool
    {
        return $user->isAbleTo('story.create')
            && $user->isAbleTo('story.update');
    }

    public function restore(User $user, Story $story): bool
    {
        return false;
    }

    public function forceDelete(User $user, Story $story): bool
    {
        return false;
    }
}
