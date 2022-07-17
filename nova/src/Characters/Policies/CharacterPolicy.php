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

    public function viewAny(User $user)
    {
        return $user->isAbleTo('character.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Character $character)
    {
        return $user->isAbleTo('character.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('character.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function createAny(User $user)
    {
        return $this->create($user) || $this->createWithoutPermissions($user)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function createWithoutPermissions(User $user)
    {
        return settings()->characters->allowCharacterCreation
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Character $character)
    {
        return $user->isAbleTo('character.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Character $character)
    {
        return $user->isAbleTo('character.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Character $character)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Character $character)
    {
        return $this->denyWithStatus(418);
    }

    public function activate(User $user, Character $character)
    {
        return $user->isAbleTo('character.update') && $character->status->equals(Inactive::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function deactivate(User $user, Character $character)
    {
        return $user->isAbleTo('character.update') && $character->status->equals(Active::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function approve(User $user, Character $character)
    {
        return $this->approveAny($user) && $character->status->equals(Pending::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function approveAny(User $user)
    {
        return $user->isAbleTo('character.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}
