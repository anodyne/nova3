<?php namespace Nova\Authorize\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class PermissionDeletor implements Deletable
{
	use BindsData;

	public function delete($permission)
	{
		// Clean up any roles that have this permission
		$permission->roles()->sync([]);

		// Delete the permission
		$permission->delete();

		return $permission;
	}
}
