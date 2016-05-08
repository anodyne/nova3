<?php namespace Nova\Core\Access\Data\Presenters;

use BasePresenter;

class PermissionPresenter extends BasePresenter {

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
