<?php

declare(strict_types=1);

namespace Nova\Characters\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Characters\Enums\CharacterType;
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
            : $this->deny();
    }

    public function view(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('character.create')
            ? $this->allow()
            : $this->deny();
    }

    public function createPrimary(User $user): Response
    {
        return $user->isAbleTo('character.create-primary')
            ? $this->allow()
            : $this->deny();
    }

    public function createSecondary(User $user): Response
    {
        return $user->isAbleTo('character.create-secondary')
            ? $this->allow()
            : $this->deny();
    }

    public function createSupport(User $user): Response
    {
        return $user->isAbleTo('character.create-support')
            ? $this->allow()
            : $this->deny();
    }

    public function createAny(User $user): Response
    {
        return match (true) {
            $this->create($user)->allowed() => $this->allow(),
            $this->createPrimary($user)->allowed() => $this->allow(),
            $this->createSecondary($user)->allowed() => $this->allow(),
            $this->createSupport($user)->allowed() => $this->allow(),
            default => $this->deny(),
        };
    }

    public function update(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.update') || $character->users->contains('id', $user->id)
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('character.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Character $character): Response
    {
        return $this->deleteAny($user);
    }

    public function restoreAny(User $user): Response
    {
        return $user->isAbleTo('character.restore')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Character $character): Response
    {
        return $this->restoreAny($user)->allowed() && $character->trashed()
            ? $this->allow()
            : $this->deny();
    }

    public function forceDelete(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.delete') && $character->trashed()
            ? $this->allow()
            : $this->deny();
    }

    public function activate(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.activate') && $character->status->equals(Inactive::class)
            ? $this->allow()
            : $this->deny();
    }

    public function activateOnCreation(User $user, Character $character): Response
    {
        if ($this->create($user)->allowed()) {
            return $this->allow();
        }

        if (
            $this->createPrimary($user)->allowed() &&
            $character->type === CharacterType::primary &&
            settings('characters.approvePrimary') === false
        ) {
            return $this->allow();
        }

        if (
            $this->createSecondary($user)->allowed() &&
            $character->type === CharacterType::secondary &&
            settings('characters.approveSecondary') === false
        ) {
            return $this->allow();
        }

        if (
            $this->createSupport($user)->allowed() &&
            $character->type === CharacterType::support &&
            settings('characters.approveSupport') === false
        ) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function deactivate(User $user, Character $character): Response
    {
        return $user->isAbleTo('character.deactivate') && $character->status->equals(Active::class)
            ? $this->allow()
            : $this->deny();
    }

    public function approve(User $user, Character $character): Response
    {
        return $this->approveAny($user)->allowed() && $character->status->equals(Pending::class)
            ? $this->allow()
            : $this->deny();
    }

    public function approveAny(User $user): Response
    {
        return $user->isAbleTo('character.update')
            ? $this->allow()
            : $this->deny();
    }

    public function selfAssign(User $user): Response
    {
        return match (true) {
            $this->create($user)->allowed() => $this->allow(),
            $this->createSecondary($user)->allowed() => $this->allow(),
            $this->createSecondary($user)->denied() && $this->createPrimary($user)->allowed() => $this->allow(),
            default => $this->deny(),
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
            $user->isAbleTo('character.update') => $this->allow(),
            $this->delete($user, $character)->allowed() => $this->allow(),
            $this->restore($user, $character)->allowed() => $this->allow(),
            default => $this->deny()
        };
    }
}
