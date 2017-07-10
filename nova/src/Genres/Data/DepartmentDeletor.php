<?php namespace Nova\Genres\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class DepartmentDeletor implements Deletable
{
	use BindsData;

	public function delete($department)
	{
		// Delete the department
		$department->delete();

		return $department;
	}
}
