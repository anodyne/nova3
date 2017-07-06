<?php namespace Nova\Authorize\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class PermissionUpdater implements Updatable
{
	use BindsData;

	public function update($permission)
	{
		$permission->update($this->data);

		return $permission->fresh();
	}
}
