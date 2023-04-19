<?php

namespace Tests\Feature\Departments;

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 */
class DuplicateDepartmentTest extends TestCase
{
    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()
            ->hasPositions(1, function (array $attributes, Department $department) {
                return ['department_id' => $department->id];
            })->create([
                'name' => 'Command',
            ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateDepartment()
    {
        $this->signInWithPermission(['department.create', 'department.update']);

        $this->followingRedirects();

        $response = $this->post(
            route('departments.duplicate', $this->department),
            ['name' => 'New Name']
        );
        $response->assertSuccessful();

        $newDepartment = Department::get()->last();

        $this->assertDatabaseHas('departments', [
            'name' => 'New Name',
        ]);

        $this->assertDatabaseHas('positions', [
            'department_id' => $newDepartment->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenDepartmentIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['department.create', 'department.update']);

        $this->post(
            route('departments.duplicate', $this->department),
            ['name' => 'New Name']
        );

        Event::assertDispatched(DepartmentDuplicated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicateDepartment()
    {
        $this->signIn();

        $response = $this->post(route('departments.duplicate', $this->department));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicateDepartment()
    {
        $response = $this->postJson(
            route('departments.duplicate', $this->department)
        );
        $response->assertUnauthorized();
    }
}
