<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionCreated;
use Nova\Departments\Models\Position;
use Nova\Departments\Requests\CreatePositionRequest;
use Tests\TestCase;

/**
 * @group positions
 */
class CreatePositionTest extends TestCase
{
    /** @test **/
    public function authorizedUserCanViewTheCreatePosition()
    {
        $this->signInWithPermission('department.create');

        $response = $this->get(route('positions.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreatePosition()
    {
        $this->signInWithPermission('department.create');

        $position = Position::factory()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('positions.store'),
            $position->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas(
            'positions',
            $position->only('name', 'description')
        );

        $this->assertRouteUsesFormRequest(
            'positions.store',
            CreatePositionRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenPositionIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('department.create');

        $this->post(
            route('positions.store'),
            Position::factory()->make()->toArray()
        );

        Event::assertDispatched(PositionCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreatePositionPage()
    {
        $this->signIn();

        $response = $this->get(route('positions.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreatePosition()
    {
        $this->signIn();

        $response = $this->postJson(
            route('positions.store'),
            Position::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreatePositionPage()
    {
        $response = $this->getJson(route('positions.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreatePosition()
    {
        $response = $this->postJson(
            route('positions.store'),
            Position::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
