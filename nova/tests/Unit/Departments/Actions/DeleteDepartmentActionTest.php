<?php

namespace Tests\Unit\Departments\Actions;

use Tests\TestCase;
use Nova\Departments\Models\Department;
use Nova\Departments\Actions\DeleteDepartment;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 */
class DeleteDepartmentActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteDepartment::class);

        $this->department = Department::factory()->create();
    }

    /** @test **/
    public function itDeletesADepartment()
    {
        $department = $this->action->execute($this->department);

        $this->assertFalse($department->exists);
    }
}
