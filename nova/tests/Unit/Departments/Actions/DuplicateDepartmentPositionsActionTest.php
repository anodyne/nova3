<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Actions\DuplicateDepartmentPositions;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 * @group positions
 */
class DuplicateDepartmentPositionsActionTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

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
        $department = DuplicateDepartment::run(
            $this->department,
            DepartmentData::from([
                'name' => 'New Name',
                'active' => true,
            ])
        );

        DuplicateDepartmentPositions::run($department, $this->department);

        $department->refresh();

        $this->assertCount(2, $department->positions);
        $this->assertCount(2, $this->department->positions);
    }
}
