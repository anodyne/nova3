<?php

namespace Tests\Feature\Departments;

use Tests\TestCase;
use Nova\Departments\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 */
class ShowDepartmentTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = create(Department::class);
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
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewADepartment()
    {
        $response = $this->getJson(route('departments.show', $this->department));
        $response->assertUnauthorized();
    }
}
