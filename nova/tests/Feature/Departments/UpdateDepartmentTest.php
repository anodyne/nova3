<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentUpdated;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\UpdateDepartmentRequest;
use Tests\TestCase;

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

        $this->department = Department::factory()->create();
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

        $department = [
            'name' => 'Command',
            'description' => 'Lorem ipsum dolor sit amet',
            'status' => 'active',
        ];

        $this->followingRedirects();

        $response = $this->put(
            route('departments.update', $this->department),
            $department
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('departments', Arr::only($department, 'name'));

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
            [
                'name' => 'Command',
                'description' => 'Lorem ipsum dolor sit amet',
                'status' => 'active',
            ]
        );

        Event::assertDispatched(DepartmentUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditDepartmentPage()
    {
        $this->signIn();

        $response = $this->get(route('departments.edit', $this->department));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateDepartment()
    {
        $this->signIn();

        $response = $this->putJson(
            route('departments.update', $this->department),
            Department::factory()->make()->toArray()
        );
        $response->assertNotFound();
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
            Department::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
