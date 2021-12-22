<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 */
class DuplicateDepartmentActionTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()->create([
            'name' => 'Command',
            'description' => 'My original description',
        ]);
    }

    /** @test **/
    public function itDuplicatesADepartment()
    {
        $department = DuplicateDepartment::run($this->department, DepartmentData::from([
            'name' => 'New Name',
            'description' => $this->department->description,
            'active' => $this->department->active,
        ]));

        $this->assertTrue($department->exists);
        $this->assertEquals('New Name', $department->name);
        $this->assertEquals('My original description', $department->description);
    }
}
