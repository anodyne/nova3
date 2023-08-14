<?php

declare(strict_types=1);

namespace Nova\Notes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;

class NotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $this->allow();
    }

    public function view(User $user, Note $note): Response
    {
        return $note->user_id === $user->id
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $this->allow();
    }

    public function update(User $user, Note $note): Response
    {
        return $note->user_id === $user->id
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $this->allow();
    }

    public function delete(User $user, Note $note): Response
    {
        return $note->user_id === $user->id
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(User $user, Note $note): Response
    {
        return $note->user_id === $user->id
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Note $note): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Note $note): Response
    {
        return $this->denyWithStatus(418);
    }
}
