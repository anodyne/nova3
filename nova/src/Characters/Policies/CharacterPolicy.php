<?php

namespace Nova\Characters\Policies;

use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any character.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('character.*');
    }

    /**
     * Determine whether the user can view the character.
     *
     * @param  User  $user
     * @param  Character  $character
     *
     * @return mixed
     */
    public function view(User $user, Character $character)
    {
        return $user->can('character.view');
    }

    /**
     * Determine whether the user can create characters.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('character.create');
    }

    /**
     * Determine whether the user can update the character.
     *
     * @param  User  $user
     * @param  Character  $character
     *
     * @return mixed
     */
    public function update(User $user, Character $character)
    {
        return $user->can('character.update');
    }

    /**
     * Determine whether the user can delete the character.
     *
     * @param  User  $user
     * @param  Character  $character
     *
     * @return mixed
     */
    public function delete(User $user, Character $character)
    {
        return $user->can('character.delete');
    }

    /**
     * Determine whether the user can restore the character.
     *
     * @param  User  $user
     * @param  Character  $character
     *
     * @return mixed
     */
    public function restore(User $user, Character $character)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the character.
     *
     * @param  User  $user
     * @param  Character  $character
     *
     * @return mixed
     */
    public function forceDelete(User $user, Character $character)
    {
        return false;
    }
}
