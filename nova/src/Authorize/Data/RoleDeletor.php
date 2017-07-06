<?php namespace Nova\Authorize\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class RoleDeletor implements Deletable
{
	use BindsData;

	public function delete($role)
	{
		// Clean up any permissions that have this role
		$role->removePermissions();

		// Delete the role
		$role->delete();

		return $role;
	}
}
