<?php namespace Nova\Users\Policies;

use Nova\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
	use HandlesAuthorization;

	public function view(User $user, User $actionUser)
	{
		return true;
	}

	public function create(User $user)
	{
		return true;
		return $user->can('role.create');
	}

	public function manage(User $user, User $actionUser)
	{
		return ($this->create($user)
			or $this->update($user, $role)
			or $this->delete($user, $role));
	}

	public function update(User $user, User $actionUser)
	{
		return true;
		return $user->can('role.update');
	}

	public function delete(User $user, User $actionUser)
	{
		return true;
		return $user->can('role.delete');
	}
}
