<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group positions
 */
class DuplicatePositionTest extends TestCase
{
    use RefreshDatabase;

    protected $postion;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = Position::factory()
            ->forDepartment([
                'name' => 'Command',
            ])
            ->create([
                'name' => 'Commanding Officer',
            ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateAPositionInTheSameDepartment()
    {
        $this->signInWithPermission(['department.create', 'department.update']);

        $this->followingRedirects();

        $response = $this->post(
            route('positions.duplicate', $this->position),
            [
                'name' => 'Executive Officer',
                'department_id' => $this->position->department_id,
            ]
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('positions', [
            'name' => 'Executive Officer',
            'department_id' => $this->position->department_id,
        ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateAPositionInANewDepartment()
    {
        $this->signInWithPermission(['department.create', 'department.update']);

        $this->followingRedirects();

        $department = Department::factory()->create();

        $response = $this->post(
            route('positions.duplicate', $this->position),
            [
                'name' => 'Executive Officer',
                'department_id' => $department->id,
            ]
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('positions', [
            'name' => 'Executive Officer',
            'department_id' => $department->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenPositionIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['department.create', 'department.update']);

        $this->post(
            route('positions.duplicate', $this->position),
            [
                'name' => 'Executive Officer',
                'department_id' => $this->position->department_id,
            ]
        );

        Event::assertDispatched(PositionDuplicated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicatePosition()
    {
        $this->signIn();

        $response = $this->post(route('positions.duplicate', $this->position));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicatePosition()
    {
        $response = $this->postJson(
            route('positions.duplicate', $this->position)
        );
        $response->assertUnauthorized();
    }
}
