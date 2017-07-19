<?php namespace Nova\Genres\Data;

use Nova\Genres\Position;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class DepartmentDeletor implements Deletable
{
	use BindsData;

	public function delete($department)
	{
		// Delete all of the positions in the department
		$department->positions->each(function ($position) {
			deletor(Position::class)->delete($position);
		});

		// Delete the department
		$department->delete();

		return $department;
	}
}
