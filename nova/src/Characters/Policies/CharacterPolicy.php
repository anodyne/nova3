<?php

namespace Nova\Characters\Policies;

use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;

class CharacterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('character.*');
    }

    public function view(User $user, Character $character): bool
    {
        return $user->can('character.view');
    }

    public function create(User $user): bool
    {
        return $user->can('character.create');
    }

    public function update(User $user, Character $character): bool
    {
        return $user->can('character.update');
    }

    public function delete(User $user, Character $character): bool
    {
        return $user->can('character.delete');
    }

    public function restore(User $user, Character $character): bool
    {
        return false;
    }

    public function forceDelete(User $user, Character $character): bool
    {
        return false;
    }

    public function activate(User $user, Character $character): bool
    {
        return $user->can('character.update')
            && $character->status->equals(Inactive::class);
    }

    public function deactivate(User $user, Character $character): bool
    {
        return $user->can('character.update')
            && $character->status->equals(Active::class);
    }
}
