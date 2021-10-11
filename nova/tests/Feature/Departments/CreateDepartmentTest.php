<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentCreated;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\CreateDepartmentRequest;
use Tests\TestCase;

/**
 * @group departments
 */
class CreateDepartmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreateDepartmentPage()
    {
        $this->signInWithPermission('department.create');

        $response = $this->get(route('departments.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateDepartment()
    {
        $this->signInWithPermission('department.create');

        $department = Department::factory()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('departments.store'),
            $department->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas(
            'departments',
            $department->only('name', 'description')
        );

        $this->assertRouteUsesFormRequest(
            'departments.store',
            CreateDepartmentRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenDepartmentIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('department.create');

        $this->post(
            route('departments.store'),
            Department::factory()->make()->toArray()
        );

        Event::assertDispatched(DepartmentCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateDepartmentPage()
    {
        $this->signIn();

        $response = $this->get(route('departments.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateDepartment()
    {
        $this->signIn();

        $response = $this->postJson(
            route('departments.store'),
            Department::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateDepartmentPage()
    {
        $response = $this->getJson(route('departments.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateDepartment()
    {
        $response = $this->postJson(
            route('departments.store'),
            Department::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
