<?php

namespace Tests\Feature\Departments;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Models\Position;
use Nova\Departments\Events\PositionUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Http\Requests\UpdatePositionRequest;

/**
 * @group departments
 * @group positions
 */
class UpdatePositionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = create(Position::class);
    }

    /** @test **/
    public function authorizedUserCanViewTheEditPositionPage()
    {
        $this->signInWithPermission('department.update');

        $response = $this->get(route('positions.edit', $this->position));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdatePosition()
    {
        $this->signInWithPermission('department.update');

        $position = make(Position::class);

        $this->followingRedirects();

        $response = $this->put(
            route('positions.update', $this->position),
            $position->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('positions', $position->only('name'));

        $this->assertRouteUsesFormRequest(
            'positions.update',
            UpdatePositionRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenPositionIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('department.update');

        $this->put(
            route('positions.update', $this->position),
            make(Position::class)->toArray()
        );

        Event::assertDispatched(PositionUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditPositionPage()
    {
        $this->signIn();

        $response = $this->get(route('positions.edit', $this->position));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdatePosition()
    {
        $this->signIn();

        $response = $this->putJson(
            route('positions.update', $this->position),
            make(Position::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditPositionPage()
    {
        $response = $this->getJson(route('positions.edit', $this->position));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdatePosition()
    {
        $response = $this->putJson(
            route('positions.update', $this->position),
            make(Position::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
