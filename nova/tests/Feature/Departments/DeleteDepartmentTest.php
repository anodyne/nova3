<?php

namespace Tests\Feature\Ranks\Groups;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Models\Department;
use Nova\Departments\Events\DepartmentDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 */
class DeleteDepartmentTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = create(Department::class);
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
        $response->assertForbidden();
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
