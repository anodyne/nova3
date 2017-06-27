<?php namespace Nova\Authorize\Presenters;

use Laracasts\Presenter\Presenter;

class RolePresenter extends Presenter
{
	public function includedPermissions()
	{
		return implode(', ', $this->entity->permissions->pluck('name')->all());
	}
}
