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
		return $user->can('user.create');
	}

	public function manage(User $user, User $actionUser)
	{
		return ($this->create($user)
			or $this->update($user, $role)
			or $this->delete($user, $role));
	}

	public function update(User $user, User $actionUser)
	{
		return $user->can('user.update');
	}

	public function delete(User $user, User $actionUser)
	{
		return $user->can('user.delete');
	}
}
