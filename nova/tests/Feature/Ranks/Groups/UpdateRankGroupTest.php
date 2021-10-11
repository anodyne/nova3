<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupUpdated;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Requests\UpdateRankGroupRequest;
use Tests\TestCase;

/**
 * @group ranks
 */
class UpdateRankGroupTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = RankGroup::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewTheEditRankGroupPage()
    {
        $this->signInWithPermission('rank.update');

        $response = $this->get(route('ranks.groups.edit', $this->group));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateARankGroup()
    {
        $this->signInWithPermission('rank.update');

        $this->followingRedirects();

        $response = $this->put(
            route('ranks.groups.update', $this->group),
            $rankGroupData = RankGroup::factory()->make()->toArray()
        );
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'ranks.groups.update',
            UpdateRankGroupRequest::class
        );

        $this->assertDatabaseHas('rank_groups', $rankGroupData);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankGroupIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('rank.update');

        $this->put(
            route('ranks.groups.update', $this->group),
            RankGroup::factory()->make()->toArray()
        );

        Event::assertDispatched(RankGroupUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditRankGroupPage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.groups.edit', $this->group));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateARankGroup()
    {
        $this->signIn();

        $response = $this->put(
            route('ranks.groups.update', $this->group),
            RankGroup::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditRankGroupPage()
    {
        $response = $this->getJson(route('ranks.groups.edit', $this->group));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateARankGroup()
    {
        $response = $this->putJson(
            route('ranks.groups.update', $this->group),
            RankGroup::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
