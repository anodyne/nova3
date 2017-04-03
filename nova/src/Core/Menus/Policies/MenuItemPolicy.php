<?php namespace Nova\Core\Menus\Policies;

use User;
use Nova\Foundation\Policies\Policy;

class MenuItemPolicy extends Policy
{
	protected $createKey = 'menu.create';
	protected $editKey = 'menu.edit';
	protected $removeKey = 'menu.remove';

	public function manageMenuPages(User $user)
	{
		return ($this->edit($user) or $user->can('page.edit'));
	}
}
