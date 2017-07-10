<?php namespace Nova\Genres\Data;

use Nova\Genres\Department;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class DepartmentCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		return Department::create($this->data);
	}
}
