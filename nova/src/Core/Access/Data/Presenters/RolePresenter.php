<?php namespace Nova\Core\Access\Data\Presenters;

use Str;
use BasePresenter;

class RolePresenter extends BasePresenter
{
	public function usersWithRole()
	{
		$count = $this->entity->users->count();

		return "$count ".Str::plural('user', $count)." with this role";
	}
}
