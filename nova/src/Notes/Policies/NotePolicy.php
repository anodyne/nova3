<?php

declare(strict_types=1);

namespace Nova\Notes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;

class NotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->allow();
    }

    public function view(User $user, Note $note)
    {
        return $user->is($note->author)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $this->allow();
    }

    public function update(User $user, Note $note)
    {
        return $user->is($note->author)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Note $note)
    {
        return $user->is($note->author)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function duplicate(User $user, Note $note)
    {
        return $user->is($note->author)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Note $note)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Note $note)
    {
        return $this->denyWithStatus(418);
    }
}
