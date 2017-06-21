<?php namespace Nova\Authorize\Policies;

use Nova\Users\User;
use Nova\Authorize\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
	use HandlesAuthorization;

	public function view(User $user, Role $role)
	{
		return true;
	}

	public function create(User $user)
	{
		return true;
		return $user->can('role.create');
	}

	public function manage(User $user, Role $role)
	{
		return ($this->create($user)
			or $this->update($user, $role)
			or $this->delete($user, $role));
	}

	public function update(User $user, Role $role)
	{
		return true;
		return $user->can('role.update');
	}

	public function delete(User $user, Role $role)
	{
		return true;
		return $user->can('role.delete');
	}
}
