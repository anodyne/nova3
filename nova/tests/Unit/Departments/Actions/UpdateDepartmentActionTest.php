<?php

namespace Tests\Unit\Departments\Actions;

use Tests\TestCase;
use Nova\Departments\Models\Department;
use Nova\Departments\Actions\UpdateDepartment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\DataTransferObjects\DepartmentData;

/**
 * @group departments
 */
class UpdateDepartmentActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateDepartment::class);

        $this->department = create(Department::class);
    }

    /** @test **/
    public function itUpdatesADepartment()
    {
        $data = new DepartmentData([
            'name' => 'Operations',
            'description' => 'Lorem consectetur adipisicing elit.',
            'active' => false,
        ]);

        $department = $this->action->execute($this->department, $data);

        $this->assertTrue($department->exists);
        $this->assertEquals('Operations', $department->name);
        $this->assertEquals('Lorem consectetur adipisicing elit.', $department->description);
        $this->assertFalse($department->active);
    }
}
