<?php namespace Nova\Authorize\Policies;

use Nova\Users\User;
use Nova\Authorize\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
	use HandlesAuthorization;

	public function create(User $user)
	{
		return $user->can('role.create');
	}

	public function delete(User $user)
	{
		return $user->can('role.delete');
	}

	public function manage(User $user)
	{
		return ($this->create($user)
			or $this->update($user)
			or $this->delete($user));
	}

	public function update(User $user)
	{
		return $user->can('role.update');
	}
}
