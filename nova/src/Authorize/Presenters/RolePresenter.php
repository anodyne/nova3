<?php namespace Nova\Authorize\Presenters;

use Nova\Foundation\Presenters\Presenter;

class RolePresenter extends Presenter
{
	public function presentIncludedPermissions()
	{
		return implode(', ', $this->permissions->pluck('name')->all());
	}
}
