<?php

namespace Nova\Authorize\Policies;

use Nova\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
	use HandlesAuthorization;

	public function create(User $user)
	{
		return $user->can('permission.create');
	}

	public function delete(User $user)
	{
		return $user->can('permission.delete');
	}

	public function manage(User $user)
	{
		return ($this->create($user)
			or $this->update($user)
			or $this->delete($user));
	}

	public function update(User $user)
	{
		return $user->can('permission.update');
	}
}
