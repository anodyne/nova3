<?php

namespace Nova\Notes\Policies;

use Nova\Notes\Models\Note;
use Nova\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any note.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the note.
     *
     * @param  User  $user
     * @param  Note  $note
     *
     * @return bool
     */
    public function view(User $user, Note $note)
    {
        return $user->is($note->author);
    }

    /**
     * Determine whether the user can create notes.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the note.
     *
     * @param  User  $user
     * @param  Note  $note
     *
     * @return bool
     */
    public function update(User $user, Note $note)
    {
        return $user->is($note->author);
    }

    /**
     * Determine whether the user can delete the note.
     *
     * @param  User  $user
     * @param  Note  $note
     *
     * @return bool
     */
    public function delete(User $user, Note $note)
    {
        return $user->is($note->author);
    }

    /**
     * Determine whether the user can duplicate the note.
     *
     * @param  User  $user
     * @param  Note  $note
     */
    public function duplicate(User $user, Note $note)
    {
        return $user->is($note->author);
    }

    /**
     * Determine whether the user can restore the note.
     *
     * @param  User  $user
     * @param  Note  $note
     *
     * @return bool
     */
    public function restore(User $user, Note $note)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the note.
     *
     * @param  User  $user
     * @param  Note  $note
     *
     * @return bool
     */
    public function forceDelete(User $user, Note $note)
    {
        return false;
    }
}
