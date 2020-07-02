<?php

namespace Tests\Feature\Ranks\Groups;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupUpdated;
use Nova\Ranks\Requests\UpdateRankGroupRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->group = create(RankGroup::class);
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
            $rankGroupData = make(RankGroup::class)->toArray()
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
            make(RankGroup::class)->toArray()
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
            make(RankGroup::class)->toArray()
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
            make(RankGroup::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
