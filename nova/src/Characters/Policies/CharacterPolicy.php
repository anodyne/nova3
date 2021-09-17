<?php

declare(strict_types=1);

namespace Nova\Characters\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Users\Models\User;

class CharacterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('character.*');
    }

    public function view(User $user, Character $character): bool
    {
        return $user->isAbleTo('character.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('character.create');
    }

    public function createAny(User $user): bool
    {
        return $this->create($user)
            || $this->createWithoutPermissions($user);
    }

    public function createWithoutPermissions(User $user): bool
    {
        return settings()->characters->allowCharacterCreation;
    }

    public function update(User $user, Character $character): bool
    {
        return $user->isAbleTo('character.update');
    }

    public function delete(User $user, Character $character): bool
    {
        return $user->isAbleTo('character.delete');
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
        return $user->isAbleTo('character.update')
            && $character->status->equals(Inactive::class);
    }

    public function deactivate(User $user, Character $character): bool
    {
        return $user->isAbleTo('character.update')
            && $character->status->equals(Active::class);
    }

    public function approve(User $user, Character $character): bool
    {
        return $this->approveAny($user)
            && $character->status->equals(Pending::class);
    }

    public function approveAny(User $user): bool
    {
        return $user->isAbleTo('character.update');
    }
}
