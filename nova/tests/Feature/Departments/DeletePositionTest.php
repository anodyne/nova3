<?php

namespace Tests\Feature\Ranks\Groups;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Models\Position;
use Nova\Departments\Events\PositionDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 * @group positions
 */
class DeletePositionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = create(Position::class);
    }

    /** @test **/
    public function authorizedUserCanDeleteAPosition()
    {
        $this->signInWithPermission('department.delete');

        $this->followingRedirects();

        $response = $this->delete(
            route('positions.destroy', $this->position)
        );
        $response->assertSuccessful();

        $this->assertDatabaseMissing(
            'positions',
            $this->position->only('id')
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenPositionIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('department.delete');

        $this->delete(route('positions.destroy', $this->position));

        Event::assertDispatched(PositionDeleted::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteAPosition()
    {
        $this->signIn();

        $response = $this->delete(
            route('positions.destroy', $this->position)
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteAPosition()
    {
        $response = $this->deleteJson(
            route('positions.destroy', $this->position)
        );
        $response->assertUnauthorized();
    }
}
