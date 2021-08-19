<?php

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Actions\DuplicateDepartmentPositions;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 * @group positions
 */
class DuplicateDepartmentPositionsActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateDepartmentPositions::class);

        $this->department = Department::factory()
            ->hasPositions(2, function (array $attributes, Department $department) {
                return ['department_id' => $department->id];
            })
            ->create([
                'name' => 'Command',
            ]);
    }

    /** @test **/
    public function itDuplicatesThePositionsFromAnotherDepartment()
    {
        $department = app(DuplicateDepartment::class)->execute(
            $this->department,
            new DepartmentData(['name' => 'New Name'])
        );

        $this->action->execute($department, $this->department);

        $department->refresh();

        $this->assertCount(2, $department->positions);
        $this->assertCount(2, $this->department->positions);
    }
}
