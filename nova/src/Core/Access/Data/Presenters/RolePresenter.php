<?php namespace Nova\Core\Access\Data\Presenters;

use Str;
use Laracasts\Presenter\Presenter;

class RolePresenter extends Presenter {

	public function usersWithRole()
	{
		$count = $this->entity->users->count();

		return "$count ".Str::plural('user', $count)." with this role";
	}

}
