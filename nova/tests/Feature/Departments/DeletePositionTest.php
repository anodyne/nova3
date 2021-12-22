<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionDeleted;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group positions
 */
class DeletePositionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = Position::factory()->create();
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
