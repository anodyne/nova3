<?php namespace Nova\Authorize\Data;

use Nova\Authorize\Permission;
use Nova\Foundation\BustsCache;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class PermissionDeletor implements Deletable
{
	use BindsData, BustsCache;

	public function delete($permission)
	{
		// Clean up any roles that have this permission
		$permission->roles()->sync([]);

		// Delete the permission
		$permission->delete();

		// Bust the cache
		$this->refreshCacheForever('nova.permissions', function () {
			return Permission::with('roles')->get();
		});

		return $permission;
	}
}
