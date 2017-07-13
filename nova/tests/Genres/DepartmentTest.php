<?php namespace Tests\Genres;

use Nova\Genres\Department;
use Tests\DatabaseTestCase;

class DepartmentTest extends DatabaseTestCase
{
	protected $department;

	public function setUp()
	{
		parent::setUp();

		$this->department = create('Nova\Genres\Department');
	}

	/** @test **/
	public function it_can_have_sub_departments()
	{
		create('Nova\Genres\Department', ['parent_id' => $this->department->id]);

		$this->assertCount(1, $this->department->fresh()->subDepartments);
	}

	/** @test **/
	public function it_can_access_its_parent_department()
	{
		$childDept = create('Nova\Genres\Department', ['parent_id' => $this->department->id]);

		$this->assertInstanceOf('Nova\Genres\Department', $childDept->parent);
	}
}
