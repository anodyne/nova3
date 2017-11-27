<?php namespace Nova\Authorize\Data;

use Nova\Authorize\Permission;
use Nova\Foundation\BustsCache;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class PermissionCreator implements Creatable
{
	use BindsData, BustsCache;

	public function create()
	{
		// Create the permission
		$permission = Permission::create($this->data);

		// Bust the cache
		$this->refreshCacheForever('nova.permissions', function () {
			return Permission::with('roles')->get();
		});

		return $permission;
	}
}
