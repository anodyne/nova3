<?php namespace Nova\Setup\Migrations;

use DB;
use Nova\Genres\Position;
use Nova\Genres\Department;

class Genres extends Migrator implements Migratable
{
	protected $depts;
	protected $positions;
	protected $deptsDictionary;
	protected $positionsDictionary;

	public function migrate()
	{
		if (config('nova2.use_nova2_data') == 1) {
			// Clear the departments and positions
			DB::table('positions')->delete();
			DB::table('departments')->delete();

			// Migrate the departments
			$this->migrateDepartments();

			// Migrate the positions
			$this->migratePositions();
		}

		return $this;
	}

	public function check()
	{
		return (
			(int)Department::count() === (int)$this->depts->count() and
			(int)Position::count() === (int)$this->positions->count()
		);
	}

	public function status()
	{
		// If we're using the default data, show a message
		if (config('nova2.use_nova2_data') == 0) {
			return [
				'status' => 'skipped',
				'message' => 'Using '.config('nova.app.name').'\'s default genre data.'
			];
		}

		if ($this->check()) {
			return ['status' => 'success', 'message' => ''];
		}

		return ['status' => 'failed', 'message' => 'Some departments/positions were not properly migrated.'];
	}

	public function setData()
	{
		// Store the dictionaries in session
		session(['nova2.depts' => $this->deptsDictionary]);
		session(['nova2.positions' => $this->positionsDictionary]);

		return $this;
	}

	protected function migrateDepartments()
	{
		// Get the Nova 2 genre
		$genre = config('nova2.genre');

		// Get all the departments from Nova 2
		$this->depts = $this->db->table("departments_{$genre}")->get();

		// Create the departments dictionary
		$deptsDictionary = [];

		$this->depts->each(function ($d) use (&$deptsDictionary) {
			// Create the department using the old data
			$newDept = creator(Department::class)->with([
				'name' => $d->dept_name,
				'description' => $d->dept_desc,
				'order' => $d->dept_order,
				'display' => ($d->dept_display == 'y') ? 1 : 0,
				'parent_id' => ($d->dept_parent == 0) ? null : $d->dept_parent,
			])->create();

			// Add the info to the departments dictionary
			$deptsDictionary[$d->dept_id] = $newDept->id;
		});

		// Update the departments dictionary
		$this->deptsDictionary = $deptsDictionary;
	}

	protected function migratePositions()
	{
		// Get the Nova 2 genre
		$genre = config('nova2.genre');

		// Get all the positions from Nova 2
		$this->positions = $this->db->table("positions_{$genre}")->get();

		// Create the positions dictionary
		$positionsDictionary = [];

		// Grab the departments dictionary for use in the anonymous function
		$deptsDictionary = $this->deptsDictionary;

		$this->positions->each(function ($p) use (&$positionsDictionary, $deptsDictionary) {
			// Create the position using the old data
			$newPosition = creator(Position::class)->with([
				'name' => $p->pos_name,
				'description' => $p->pos_desc,
				'order' => $p->pos_order,
				'department_id' => array_get($deptsDictionary, $p->pos_dept, null),
				'available' => $p->pos_open,
				'display' => ($p->pos_display == 'y') ? 1 : 0,
			])->create();

			// Add the info to the positions dictionary
			$positionsDictionary[$p->pos_id] = $newPosition->id;
		});

		// Update the positions dictionary
		$this->positionsDictionary = $positionsDictionary;
	}
}
