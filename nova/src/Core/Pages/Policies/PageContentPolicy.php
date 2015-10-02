<?php namespace Nova\Core\Pages\Policies;

use User;

class PageContentPolicy {

	public function create(User $user)
	{
		return $user->can('page.create');
	}

	public function edit(User $user)
	{
		return $user->can('page.edit');
	}

	public function manage(User $user)
	{
		return ($this->create($user) or $this->edit($user) or $this->remove($user));
	}

	public function remove(User $user)
	{
		return $user->can('page.remove');
	}

}
