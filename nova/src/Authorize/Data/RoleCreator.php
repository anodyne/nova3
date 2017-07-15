<?php namespace Nova\Authorize\Data;

use Nova\Authorize\Role;
use Nova\Foundation\BustsCache;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class RoleCreator implements Creatable
{
	use BindsData, BustsCache;

	public function create()
	{
		// Create the role
		$role = Role::create($this->data);

		// Attach the permissions to the role if we have them
		if (array_key_exists('permissions', $this->data)) {
			$role->updatePermissions($this->data['permissions']);
		}

		// Bust the cache
		$this->refreshCacheForever('nova.roles', function () {
			return Role::with('permissions')->get();
		});

		return $role;
	}
}
