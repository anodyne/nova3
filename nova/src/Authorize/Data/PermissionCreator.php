<?php namespace Nova\Authorize\Data;

use Nova\Authorize\Permission;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class PermissionCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		return Permission::create($this->data);
	}
}
