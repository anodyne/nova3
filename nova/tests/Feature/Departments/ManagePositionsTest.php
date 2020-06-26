<?php

namespace Tests\Feature\Departments;

use Tests\TestCase;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 * @group positions
 */
class ManagePositionsTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = create(Position::class, [
            'name' => 'Captain',
        ]);
    }

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.create');

        $response = $this->get(
            route('positions.index', $this->position->department)
        );
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.update');

        $response = $this->get(
            route('positions.index', $this->position->department)
        );
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.delete');

        $response = $this->get(
            route('positions.index', $this->position->department)
        );
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.view');

        $response = $this->get(
            route('positions.index', $this->position->department)
        );
        $response->assertSuccessful();
    }

    /** @test **/
    public function positionsCanBeFilteredByName()
    {
        $this->signInWithPermission('department.create');

        $response = $this->get(
            route('positions.index', $this->position->department)
        );
        $response->assertSuccessful();

        $this->assertEquals(Department::count(), $response['positions']->total());

        $response = $this->get(
            route('positions.index', [$this->position->department, 'search=captain'])
        );
        $response->assertSuccessful();

        $this->assertCount(1, $response['positions']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManagePositionsPage()
    {
        $this->signIn();

        $response = $this->get(
            route('positions.index', $this->position->department)
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManagePositionsPage()
    {
        $response = $this->getJson(
            route('positions.index', $this->position->department)
        );
        $response->assertUnauthorized();
    }
}
