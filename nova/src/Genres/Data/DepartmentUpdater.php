<?php namespace Nova\Genres\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class DepartmentUpdater implements Updatable
{
	use BindsData;

	public function update($department)
	{
		$department->update($this->data);

		return $department->fresh();
	}
}
