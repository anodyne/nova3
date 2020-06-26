<?php

namespace Nova\Departments\Policies;

use Nova\Users\Models\User;
use Nova\Departments\Models\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any position.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->can('department.*');
    }

    /**
     * Determine whether the user can view the position.
     *
     * @param  User  $user
     * @param  Position  $position
     *
     * @return bool
     */
    public function view(User $user, Position $position)
    {
        return $user->can('department.view');
    }

    /**
     * Determine whether the user can create positions.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('department.create');
    }

    /**
     * Determine whether the user can update the position.
     *
     * @param  User  $user
     * @param  Position  $position
     *
     * @return bool
     */
    public function update(User $user, Position $position)
    {
        return $user->can('department.update');
    }

    /**
     * Determine whether the user can delete the position.
     *
     * @param  User  $user
     * @param  Position  $position
     *
     * @return bool
     */
    public function delete(User $user, Position $position)
    {
        return $user->can('department.delete');
    }

    /**
     * Determine whether the user can restore the position.
     *
     * @param  User  $user
     * @param  Position  $position
     *
     * @return bool
     */
    public function restore(User $user, Position $position)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the position.
     *
     * @param  User  $user
     * @param  Position  $position
     *
     * @return bool
     */
    public function forceDelete(User $user, Position $position)
    {
        return false;
    }
}
