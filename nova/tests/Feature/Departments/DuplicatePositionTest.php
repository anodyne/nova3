<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group departments
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
    public function authorizedUserCanDuplicatePosition()
    {
        $this->signInWithPermission(['department.create', 'department.update']);

        $this->followingRedirects();

        $response = $this->post(
            route('positions.duplicate', $this->position),
            ['name' => 'Executive Officer']
        );
        $response->assertSuccessful();

        $newPosition = Position::get()->last();

        $this->assertDatabaseHas('positions', [
            'name' => 'Executive Officer',
            'department_id' => $newPosition->department_id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenPositionIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['department.create', 'department.update']);

        $this->post(
            route('positions.duplicate', $this->position),
            ['name' => 'Executive Officer']
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
