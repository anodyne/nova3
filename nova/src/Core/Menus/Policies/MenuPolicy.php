<?php namespace Nova\Core\Menus\Policies;

use User;
use Nova\Foundation\Policies\Policy;

class MenuPolicy extends Policy
{
	protected $createKey = 'menu.create';
	protected $editKey = 'menu.edit';
	protected $removeKey = 'menu.remove';

	public function manageMenuItems(User $user)
	{
		return ($this->create($user) or $this->edit($user) or $this->remove($user));
	}

	public function manageMenuPages(User $user)
	{
		return ($this->edit($user) and $user->can('page.edit'));
	}
}
