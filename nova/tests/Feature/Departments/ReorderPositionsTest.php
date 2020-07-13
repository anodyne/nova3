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
class ReorderPositionsTest extends TestCase
{
    use RefreshDatabase;

    protected $position1;

    protected $position2;

    protected $position3;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = create(Department::class);

        $this->position1 = create(Position::class, [
            'sort' => 0,
            'department_id' => $this->department,
        ]);
        $this->position2 = create(Position::class, [
            'sort' => 1,
            'department_id' => $this->department,
        ]);
        $this->position3 = create(Position::class, [
            'sort' => 2,
            'department_id' => $this->department,
        ]);
    }

    /** @test **/
    public function authorizedUserCanReorderPositions()
    {
        $this->signInWithPermission('department.update');

        $this->followingRedirects();

        $response = $this->post(
            route('positions.reorder', $this->department),
            [
                'sort' => implode(',', [
                    $this->position3->id,
                    $this->position2->id,
                    $this->position1->id,
                ]),
            ]
        );
        $response->assertSuccessful();

        $this->position1->fresh();
        $this->position2->fresh();
        $this->position3->fresh();

        $this->assertDatabaseHas('positions', [
            'id' => $this->position1->id,
            'sort' => 2,
        ]);
        $this->assertDatabaseHas('positions', [
            'id' => $this->position2->id,
            'sort' => 1,
        ]);
        $this->assertDatabaseHas('positions', [
            'id' => $this->position3->id,
            'sort' => 0,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotReorderPositions()
    {
        $this->signIn();

        $response = $this->post(
            route('positions.reorder', $this->department),
            [
                'sort' => implode(',', [
                    $this->position3->id,
                    $this->position2->id,
                    $this->position1->id,
                ]),
            ]
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotReorderPositions()
    {
        $response = $this->postJson(
            route('positions.reorder', $this->department),
            [
                'sort' => implode(',', [
                    $this->position3->id,
                    $this->position2->id,
                    $this->position1->id,
                ]),
            ]
        );
        $response->assertUnauthorized();
    }
}
