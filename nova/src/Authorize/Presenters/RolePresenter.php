<?php namespace Nova\Authorize\Presenters;

use Nova\Foundation\Presenters\Presenter;

class RolePresenter extends Presenter
{
	public function includedPermissions()
	{
		return implode(', ', $this->entity->permissions->pluck('name')->all());
	}
}
