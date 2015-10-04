<?php namespace Nova\Core\Access\Policies;

use User;

class RolePolicy {

	public function create(User $user)
	{
		return $user->can('access.create');
	}

	public function edit(User $user)
	{
		return $user->can('access.edit');
	}

	public function manage(User $user)
	{
		return ($this->create($user) or $this->edit($user) or $this->remove($user));
	}

	public function remove(User $user)
	{
		return $user->can('access.remove');
	}

}
