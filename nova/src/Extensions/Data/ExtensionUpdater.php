<?php namespace Nova\Authorize\Data;

use Nova\Authorize\Permission;
use Nova\Foundation\BustsCache;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class ExtensionUpdater implements Updatable
{
	use BindsData, BustsCache;

	public function update($permission)
	{
		// Update the permission
		$permission->update($this->data);

		// Bust the cache
		$this->refreshCacheForever('nova.permissions', function () {
			return Permission::with('roles')->get();
		});

		return $permission->fresh();
	}
}
