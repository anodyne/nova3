<?php

namespace Tests\Feature\Ranks;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Events\RankGroupDuplicated;

/**
 * @group ranks
 */
class DuplicateRankGroupTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = create(RankGroup::class, [
            'name' => 'Command',
        ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateRankGroup()
    {
        $this->signInWithPermission(['rank.create', 'rank.update']);

        $this->followingRedirects();

        $response = $this->post(route('ranks.groups.duplicate', $this->group));
        $response->assertSuccessful();

        $this->assertDatabaseHas('rank_groups', [
            'name' => "Copy of {$this->group->name}",
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankGroupIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['rank.create', 'rank.update']);

        $this->post(route('ranks.groups.duplicate', $this->group));

        Event::assertDispatched(RankGroupDuplicated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicateRankGroup()
    {
        $this->signIn();

        $response = $this->post(route('ranks.groups.duplicate', $this->group));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicateRankGroup()
    {
        $response = $this->postJson(
            route('ranks.groups.duplicate', $this->group)
        );
        $response->assertUnauthorized();
    }
}
