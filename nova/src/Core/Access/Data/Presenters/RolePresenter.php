<?php namespace Nova\Core\Access\Data\Presenters;

use Str, BasePresenter;

class RolePresenter extends BasePresenter {

	public function displayName()
	{
		return $this->entity->display_name;
	}

	public function key()
	{
		return $this->name();
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function usersWithRole()
	{
		$count = $this->entity->users->count();

		return "$count ".Str::plural('user', $count)." with this role";
	}

}
