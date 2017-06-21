<?php namespace Nova\Authorize\Policies;

use Nova\Users\User;
use Nova\Authorize\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
	use HandlesAuthorization;

	public function view(User $user, Permission $permission)
	{
		return true;
	}

	public function create(User $user)
	{
		return true;
		return $user->can('permission.create');
	}

	public function manage(User $user, Permission $permission)
	{
		return ($this->create($user)
			or $this->update($user, $permission)
			or $this->delete($user, $permission));
	}

	public function update(User $user, Permission $permission)
	{
		return true;
		return $user->can('permission.update');
	}

	public function delete(User $user, Permission $permission)
	{
		return true;
		return $user->can('permission.delete');
	}
}
