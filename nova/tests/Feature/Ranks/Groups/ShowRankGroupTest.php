<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

/**
 * @group ranks
 */
class ShowRankGroupTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = RankGroup::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewARankGroup()
    {
        $this->signInWithPermission('rank.view');

        $response = $this->get(route('ranks.groups.show', $this->group));
        $response->assertSuccessful();
        $response->assertViewHas('group', $this->group);
        $response->assertViewHas('group.ranks', $this->group->ranks);
    }

    /** @test **/
    public function unauthorizedUserCannotViewARankGroup()
    {
        $this->signIn();

        $response = $this->get(route('ranks.groups.show', $this->group));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewARankGroup()
    {
        $response = $this->getJson(route('ranks.groups.show', $this->group));
        $response->assertUnauthorized();
    }
}
