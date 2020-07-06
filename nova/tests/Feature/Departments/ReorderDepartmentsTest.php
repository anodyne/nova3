<?php

namespace Tests\Feature\Departments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Models\Department;

/**
 * @group departments
 */
class ReorderDepartmentsTest extends TestCase
{
    use RefreshDatabase;

    protected $dept1;

    protected $dept2;

    protected $dept3;

    public function setUp(): void
    {
        parent::setUp();

        $this->dept1 = create(Department::class, ['sort' => 0]);
        $this->dept2 = create(Department::class, ['sort' => 1]);
        $this->dept3 = create(Department::class, ['sort' => 2]);
    }

    /** @test **/
    public function authorizedUserCanReorderDepartments()
    {
        $this->signInWithPermission('department.update');

        $this->followingRedirects();

        $response = $this->post(
            route('departments.reorder'),
            [
                'sort' => implode(',', [
                    $this->dept3->id,
                    $this->dept2->id,
                    $this->dept1->id,
                ]),
            ]
        );
        $response->assertSuccessful();

        $this->dept1->fresh();
        $this->dept2->fresh();
        $this->dept3->fresh();

        $this->assertDatabaseHas('departments', [
            'id' => $this->dept1->id,
            'sort' => 2,
        ]);
        $this->assertDatabaseHas('departments', [
            'id' => $this->dept2->id,
            'sort' => 1,
        ]);
        $this->assertDatabaseHas('departments', [
            'id' => $this->dept3->id,
            'sort' => 0,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotReorderDepartments()
    {
        $this->signIn();

        $response = $this->post(
            route('departments.reorder'),
            [
                'sort' => implode(',', [
                    $this->dept3->id,
                    $this->dept2->id,
                    $this->dept1->id,
                ]),
            ]
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotReorderDepartments()
    {
        $response = $this->postJson(
            route('departments.reorder'),
            [
                'sort' => implode(',', [
                    $this->dept3->id,
                    $this->dept2->id,
                    $this->dept1->id,
                ]),
            ]
        );
        $response->assertUnauthorized();
    }
}