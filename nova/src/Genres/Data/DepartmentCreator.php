<?php namespace Nova\Genres\Data;

use Nova\Genres\Position;
use Nova\Genres\Department;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class DepartmentCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		$department = Department::create($this->data);

		if (array_key_exists('positions', $this->data)) {
			foreach ($this->data['positions'] as $position) {
				// Set the data we want to use
				$positionData = [
					'name' => $position['name'],
					'available' => 1,
					'display' => (int) true
				];

				// Create the position
				$position = creator(Position::class)->with($positionData)->create();

				// Associate it with the department
				$department->positions()->save($position);
			}
		}

		return $department;
	}
}
