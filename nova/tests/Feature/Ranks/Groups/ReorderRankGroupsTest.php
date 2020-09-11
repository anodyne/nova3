<?php

namespace Tests\Feature\Ranks\Groups;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class ReorderRankGroupsTest extends TestCase
{
    use RefreshDatabase;

    protected $group1;

    protected $group2;

    protected $group3;

    public function setUp(): void
    {
        parent::setUp();

        $this->group1 = RankGroup::factory()->create(['sort' => 0]);
        $this->group2 = RankGroup::factory()->create(['sort' => 1]);
        $this->group3 = RankGroup::factory()->create(['sort' => 2]);
    }

    /** @test **/
    public function authorizedUserCanReorderRankGroups()
    {
        $this->signInWithPermission('rank.update');

        $this->followingRedirects();

        $response = $this->post(
            route('ranks.groups.reorder'),
            [
                'sort' => implode(',', [
                    $this->group3->id,
                    $this->group2->id,
                    $this->group1->id,
                ]),
            ]
        );
        $response->assertSuccessful();

        $this->group1->fresh();
        $this->group2->fresh();
        $this->group3->fresh();

        $this->assertDatabaseHas('rank_groups', [
            'id' => $this->group1->id,
            'sort' => 2,
        ]);
        $this->assertDatabaseHas('rank_groups', [
            'id' => $this->group2->id,
            'sort' => 1,
        ]);
        $this->assertDatabaseHas('rank_groups', [
            'id' => $this->group3->id,
            'sort' => 0,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotReorderRankGroups()
    {
        $this->signIn();

        $response = $this->post(
            route('ranks.groups.reorder'),
            [
                'sort' => implode(',', [
                    $this->group3->id,
                    $this->group2->id,
                    $this->group1->id,
                ]),
            ]
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotReorderRankGroups()
    {
        $response = $this->postJson(
            route('ranks.groups.reorder'),
            [
                'sort' => implode(',', [
                    $this->group3->id,
                    $this->group2->id,
                    $this->group1->id,
                ]),
            ]
        );
        $response->assertUnauthorized();
    }
}
