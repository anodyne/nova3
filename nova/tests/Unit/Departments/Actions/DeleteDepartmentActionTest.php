<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DeleteDepartment;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 */
class DeleteDepartmentActionTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()->create();
    }

    /** @test **/
    public function itDeletesADepartment()
    {
        $department = DeleteDepartment::run($this->department);

        $this->assertFalse($department->exists);
    }
}
