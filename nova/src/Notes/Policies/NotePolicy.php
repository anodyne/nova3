<?php

namespace Nova\Notes\Policies;

use Nova\Notes\Models\Note;
use Nova\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Note $note): bool
    {
        return $user->is($note->author);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Note $note): bool
    {
        return $user->is($note->author);
    }

    public function delete(User $user, Note $note): bool
    {
        return $user->is($note->author);
    }

    public function duplicate(User $user, Note $note): bool
    {
        return $user->is($note->author);
    }

    public function restore(User $user, Note $note): bool
    {
        return false;
    }

    public function forceDelete(User $user, Note $note): bool
    {
        return false;
    }
}
