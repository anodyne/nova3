<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDeleted;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 */
class DeleteDepartmentTest extends TestCase
{
    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteADepartment()
    {
        $this->signInWithPermission('department.delete');

        $this->followingRedirects();

        $response = $this->delete(
            route('departments.destroy', $this->department)
        );
        $response->assertSuccessful();

        $this->assertDatabaseMissing(
            'departments',
            $this->department->only('id')
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenDepartmentIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('department.delete');

        $this->delete(route('departments.destroy', $this->department));

        Event::assertDispatched(DepartmentDeleted::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteADepartment()
    {
        $this->signIn();

        $response = $this->delete(
            route('departments.destroy', $this->department)
        );
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteADepartment()
    {
        $response = $this->deleteJson(
            route('departments.destroy', $this->department)
        );
        $response->assertUnauthorized();
    }
}
