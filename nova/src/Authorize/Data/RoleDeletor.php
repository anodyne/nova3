<?php namespace Nova\Authorize\Data;

use Nova\Authorize\Role;
use Nova\Foundation\BustsCache;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class RoleDeletor implements Deletable
{
	use BindsData, BustsCache;

	public function delete($role)
	{
		// Clean up any permissions that have this role
		$role->removePermissions();

		// Delete the role
		$role->delete();

		// Bust the cache
		$this->refreshCacheForever('nova.roles', function () {
			return Role::with('permissions')->get();
		});

		return $role;
	}
}
