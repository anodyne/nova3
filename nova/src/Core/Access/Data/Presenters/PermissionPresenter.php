<?php namespace Nova\Core\Access\Data\Presenters;

use Str;
use Laracasts\Presenter\Presenter;

class PermissionPresenter extends Presenter {

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

	public function rolesAsLabels()
	{
		$output = "";

		foreach ($this->entity->roles as $role)
		{
			$output.= label('default', $role->present()->name)."\t";
		}

		return $output;
	}

}
