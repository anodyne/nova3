<?php namespace Nova\Core\Users\Policies;

use User;

class UserPolicy {

	public function create(User $user)
	{
		return $user->can('user.create');
	}

	public function edit(User $user, User $resource)
	{
		return $user->id === $resource->id or $user->can('user.edit');
	}

	public function editAll(User $user)
	{
		return $user->can('user.edit');
	}

	public function export(User $user)
	{
		$user->can('user.edit');
	}

	public function exportAll(User $user)
	{
		return $user->can('user.edit');
	}

	public function manage(User $user)
	{
		return ($this->create($user) or $this->editAll($user) or $this->remove($user));
	}

	public function remove(User $user)
	{
		return $user->can('user.remove');
	}

}
