<?php

declare(strict_types=1);

namespace Nova\Characters\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Characters\Models\States\Status\Pending;
use Nova\Users\Models\User;

class CharacterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('character.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('character.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function createPrimary(User $user): Response
    {
        return $user->isAbleTo('character.create-primary')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function createSecondary(User $user): Response
    {
        return $user->isAbleTo('character.create-secondary')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function createSupport(User $user): Response
    {
        return $user->isAbleTo('character.create-support')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function createAny(User $user): Response
    {
        return match (true) {
            $this->create($user)->allowed() => $this->allow(),
            $this->createPrimary($user)->allowed() => $this->allow(),
            $this->createSecondary($user)->allowed() => $this->allow(),
            $this->createSupport($user)->allowed() => $this->allow(),
            default => $this->denyAsNotFound(),
        };
    }

    public function update(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Character $character): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Character $character): Response
    {
        return $this->denyWithStatus(418);
    }

    public function activate(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.update') && $character->status->equals(Inactive::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function deactivate(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.update') && $character->status->equals(Active::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function approve(User $user, Character $character): Response
    {
        return $this->approveAny($user)->allowed() && $character->status->equals(Pending::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function approveAny(User $user): Response
    {
        return $user->isAbleTo('character.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function selfAssign(User $user): Response
    {
        return match (true) {
            $this->create($user)->allowed() => $this->allow(),
            $this->createSecondary($user)->allowed() => $this->allow(),
            $this->createSecondary($user)->denied() && $this->createPrimary($user)->allowed() => $this->allow(),
            default => $this->denyAsNotFound(),
        };
    }

    public function assignAsPrimary(User $user): Response
    {
        if ($this->create($user)->allowed()) {
            return $this->allow();
        }

        return $this->createPrimary($user);
    }

    public function manage(User $user, Character $character): Response
    {
        return match (true) {
            $this->create($user)->allowed() => $this->allow(),
            $this->update($user, $character)->allowed() => $this->allow(),
            $this->delete($user, $character)->allowed() => $this->allow(),
            default => $this->denyAsNotFound()
        };
    }
}
