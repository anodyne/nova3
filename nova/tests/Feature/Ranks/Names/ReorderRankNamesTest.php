<?php

namespace Tests\Feature\Ranks\Names;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class ReorderRankNamesTest extends TestCase
{
    use RefreshDatabase;

    protected $name1;

    protected $name2;

    protected $name3;

    public function setUp(): void
    {
        parent::setUp();

        $this->name1 = RankName::factory()->create(['sort' => 0]);
        $this->name2 = RankName::factory()->create(['sort' => 1]);
        $this->name3 = RankName::factory()->create(['sort' => 2]);
    }

    /** @test **/
    public function authorizedUserCanReorderRankNames()
    {
        $this->signInWithPermission('rank.update');

        $this->followingRedirects();

        $response = $this->post(
            route('ranks.names.reorder'),
            [
                'sort' => implode(',', [
                    $this->name3->id,
                    $this->name2->id,
                    $this->name1->id,
                ]),
            ]
        );
        $response->assertSuccessful();

        $this->name1->fresh();
        $this->name2->fresh();
        $this->name3->fresh();

        $this->assertDatabaseHas('rank_names', [
            'id' => $this->name1->id,
            'sort' => 2,
        ]);
        $this->assertDatabaseHas('rank_names', [
            'id' => $this->name2->id,
            'sort' => 1,
        ]);
        $this->assertDatabaseHas('rank_names', [
            'id' => $this->name3->id,
            'sort' => 0,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotReorderRankNames()
    {
        $this->signIn();

        $response = $this->post(
            route('ranks.names.reorder'),
            [
                'sort' => implode(',', [
                    $this->name3->id,
                    $this->name2->id,
                    $this->name1->id,
                ]),
            ]
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotReorderRankNames()
    {
        $response = $this->postJson(
            route('ranks.names.reorder'),
            [
                'sort' => implode(',', [
                    $this->name3->id,
                    $this->name2->id,
                    $this->name1->id,
                ]),
            ]
        );
        $response->assertUnauthorized();
    }
}
