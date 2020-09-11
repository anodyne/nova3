<?php

namespace Tests\Feature\Ranks\Groups;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupDuplicated;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->group = RankGroup::factory()
            ->hasRanks(1, function (array $attributes, RankGroup $group) {
                return ['group_id' => $group->id];
            })->create([
                'name' => 'Command',
            ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateRankGroup()
    {
        $this->signInWithPermission(['rank.create', 'rank.update']);

        $this->followingRedirects();

        $response = $this->post(
            route('ranks.groups.duplicate', $this->group),
            ['name' => 'New Name', 'base_image' => 'foo.png']
        );
        $response->assertSuccessful();

        $newGroup = RankGroup::get()->last();

        $this->assertDatabaseHas('rank_groups', [
            'name' => 'New Name',
        ]);

        $this->assertDatabaseHas('rank_items', [
            'group_id' => $newGroup->id,
            'base_image' => 'foo.png',
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankGroupIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['rank.create', 'rank.update']);

        $this->post(
            route('ranks.groups.duplicate', $this->group),
            ['name' => 'New Name', 'base_image' => 'foo.png']
        );

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
