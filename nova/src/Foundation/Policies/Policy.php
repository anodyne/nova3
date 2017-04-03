<?php namespace Nova\Foundation;

use User;

abstract class Policy
{
	protected $editKey;
	protected $createKey;
	protected $removeKey;
	
	public function create(User $user)
	{
		return $user->can($this->createKey);
	}

	public function edit(User $user)
	{
		return $user->can($this->editKey);
	}

	public function manage(User $user)
	{
		return ($this->create($user) or $this->edit($user) or $this->remove($user));
	}

	public function remove(User $user)
	{
		return $user->can($this->removeKey);
	}
}
