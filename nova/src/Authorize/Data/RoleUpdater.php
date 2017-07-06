<?php namespace Nova\Authorize\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class RoleUpdater implements Updatable
{
	use BindsData;

	public function update($role)
	{
		// Update the role
		$role->update($this->data);

		// Attach the permissions if we have them
		if (array_key_exists('permissions', $this->data)) {
			$role->updatePermissions($this->data['permissions']);
		}

		return $role->fresh();
	}
}
