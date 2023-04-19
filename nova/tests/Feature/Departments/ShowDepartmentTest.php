<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 */
class ShowDepartmentTest extends TestCase
{
    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewADepartment()
    {
        $this->signInWithPermission('department.view');

        $response = $this->get(route('departments.show', $this->department));
        $response->assertSuccessful();
        $response->assertViewHas('department', $this->department);
    }

    /** @test **/
    public function unauthorizedUserCannotViewADepartment()
    {
        $this->signIn();

        $response = $this->get(route('departments.show', $this->department));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewADepartment()
    {
        $response = $this->getJson(route('departments.show', $this->department));
        $response->assertUnauthorized();
    }
}
