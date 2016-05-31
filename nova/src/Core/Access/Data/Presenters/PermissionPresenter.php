<?php namespace Nova\Core\Access\Data\Presenters;

use BasePresenter;

class PermissionPresenter extends BasePresenter {

	public function rolesAsLabels()
	{
		return implode("\t", $this->entity->roles->map(function ($role)
		{
			return label('default', $role->present()->name);
		})->toArray());
	}
}
