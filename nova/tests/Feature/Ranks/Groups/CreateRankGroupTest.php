<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupCreated;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Requests\CreateRankGroupRequest;
use Tests\TestCase;

/**
 * @group ranks
 */
class CreateRankGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreateRankGroupPage()
    {
        $this->signInWithPermission('rank.create');

        $response = $this->get(route('ranks.groups.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateARankGroup()
    {
        $this->signInWithPermission('rank.create');

        $this->followingRedirects();

        $response = $this->post(
            route('ranks.groups.store'),
            $rankGroupData = RankGroup::factory()->make()->toArray()
        );
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'ranks.groups.store',
            CreateRankGroupRequest::class
        );

        $this->assertDatabaseHas('rank_groups', $rankGroupData);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankGroupIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('rank.create');

        $this->post(
            route('ranks.groups.store'),
            RankGroup::factory()->make()->toArray()
        );

        Event::assertDispatched(RankGroupCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateRankGroupPage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.groups.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateARankGroup()
    {
        $this->signIn();

        $response = $this->post(
            route('ranks.groups.store'),
            RankGroup::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateRankGroupPage()
    {
        $response = $this->getJson(route('ranks.groups.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateARankGroup()
    {
        $response = $this->postJson(
            route('ranks.groups.store'),
            RankGroup::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
