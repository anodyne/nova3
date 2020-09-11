<?php

namespace Tests\Feature\Departments;

use Tests\TestCase;
use Nova\Departments\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 */
class ManageDepartmentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.create');

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.update');

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.delete');

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.view');

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function departmentsCanBeFilteredByName()
    {
        $this->signInWithPermission('department.create');

        Department::factory()->create([
            'name' => 'Command',
        ]);

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();

        $this->assertEquals(Department::count(), $response['departments']->total());

        $response = $this->get(route('departments.index', 'search=command'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['departments']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageDepartmentsPage()
    {
        $this->signIn();

        $response = $this->get(route('departments.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageDepartmentsPage()
    {
        $response = $this->getJson(route('departments.index'));
        $response->assertUnauthorized();
    }
}
