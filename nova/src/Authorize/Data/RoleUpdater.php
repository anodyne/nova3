<?php namespace Nova\Authorize\Data;

use Nova\Authorize\Role;
use Nova\Foundation\BustsCache;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class RoleUpdater implements Updatable
{
	use BindsData, BustsCache;

	public function update($role)
	{
		// Update the role
		$role->update($this->data);

		// Attach the permissions if we have them
		if (array_key_exists('permissions', $this->data)) {
			$role->updatePermissions($this->data['permissions']);
		}

		// Bust the cache
		$this->refreshCacheForever('nova.roles', function () {
			return Role::with('permissions')->get();
		});

		return $role->fresh();
	}
}
