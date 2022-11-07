<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
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

        $department = [
            'name' => 'Command',
            'description' => 'Lorem ipsum dolor sit amet',
            'status' => 'active',
        ];

        $this->followingRedirects();

        $response = $this->post(
            route('departments.store'),
            $department
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas(
            'departments',
            Arr::only($department, ['name', 'description'])
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
            [
                'name' => 'Command',
                'description' => 'Lorem ipsum dolor sit amet',
                'status' => 'active',
            ]
        );

        Event::assertDispatched(DepartmentCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateDepartmentPage()
    {
        $this->signIn();

        $response = $this->get(route('departments.create'));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateDepartment()
    {
        $this->signIn();

        $response = $this->postJson(
            route('departments.store'),
            Department::factory()->make()->toArray()
        );
        $response->assertNotFound();
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
