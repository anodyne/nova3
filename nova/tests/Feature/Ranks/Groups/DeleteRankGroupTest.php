<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupDeleted;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

/**
 * @group ranks
 */
class DeleteRankGroupTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = RankGroup::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteARankGroup()
    {
        $this->signInWithPermission('rank.delete');

        $this->followingRedirects();

        $response = $this->delete(route('ranks.groups.destroy', $this->group));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('rank_groups', $this->group->only('id'));
    }

    /** @test **/
    public function eventIsDispatchedWhenRankGroupIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('rank.delete');

        $this->delete(route('ranks.groups.destroy', $this->group));

        Event::assertDispatched(RankGroupDeleted::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteARankGroup()
    {
        $this->signIn();

        $response = $this->delete(route('ranks.groups.destroy', $this->group));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteARankGroup()
    {
        $response = $this->deleteJson(
            route('ranks.groups.destroy', $this->group)
        );
        $response->assertUnauthorized();
    }
}
