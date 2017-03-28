<?php namespace Nova\Core\Menus\Policies;

use User;

class MenuPolicy
{
	public function create(User $user)
	{
		return $user->can('menu.create');
	}

	public function edit(User $user)
	{
		return $user->can('menu.edit');
	}

	public function manage(User $user)
	{
		return ($this->create($user) or $this->edit($user) or $this->remove($user));
	}

	public function manageMenuItems(User $user)
	{
		return ($this->create($user) or $this->edit($user) or $this->remove($user));
	}

	public function manageMenuPages(User $user)
	{
		return ($this->edit($user) and $user->can('page.edit'));
	}

	public function remove(User $user)
	{
		return $user->can('menu.remove');
	}
}
