<?php

namespace Tests\Feature\Departments;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Models\Department;
use Nova\Departments\Events\DepartmentUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Http\Requests\UpdateDepartmentRequest;

/**
 * @group departments
 */
class UpdateDepartmentTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = create(Department::class);
    }

    /** @test **/
    public function authorizedUserCanViewTheEditDepartmentPage()
    {
        $this->signInWithPermission('department.update');

        $response = $this->get(route('departments.edit', $this->department));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateDepartment()
    {
        $this->signInWithPermission('department.update');

        $department = make(Department::class);

        $this->followingRedirects();

        $response = $this->put(
            route('departments.update', $this->department),
            $department->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('departments', $department->only('name'));

        $this->assertRouteUsesFormRequest(
            'departments.update',
            UpdateDepartmentRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenDepartmentIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('department.update');

        $this->put(
            route('departments.update', $this->department),
            make(Department::class)->toArray()
        );

        Event::assertDispatched(DepartmentUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditDepartmentPage()
    {
        $this->signIn();

        $response = $this->get(route('departments.edit', $this->department));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateDepartment()
    {
        $this->signIn();

        $response = $this->putJson(
            route('departments.update', $this->department),
            make(Department::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditDepartmentPage()
    {
        $response = $this->getJson(route('departments.edit', $this->department));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateDepartment()
    {
        $response = $this->putJson(
            route('departments.update', $this->department),
            make(Department::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
