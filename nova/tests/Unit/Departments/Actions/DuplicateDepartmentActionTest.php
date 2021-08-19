<?php

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 */
class DuplicateDepartmentActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateDepartment::class);

        $this->department = Department::factory()->create([
            'name' => 'Command',
            'description' => 'My original description',
        ]);
    }

    /** @test **/
    public function itDuplicatesADepartment()
    {
        $department = $this->action->execute($this->department, new DepartmentData([
            'name' => 'New Name',
            'description' => $this->department->description,
            'active' => $this->department->active,
        ]));

        $this->assertTrue($department->exists);
        $this->assertEquals('New Name', $department->name);
        $this->assertEquals('My original description', $department->description);
    }
}
