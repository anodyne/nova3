<?php namespace Nova\Core\Users\Policies;

use User;
use Nova\Foundation\Policies\Policy;

class UserPolicy extends Policy
{
	protected $createKey = 'user.create';
	protected $editKey = 'user.edit';
	protected $removeKey = 'user.remove';

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
}
