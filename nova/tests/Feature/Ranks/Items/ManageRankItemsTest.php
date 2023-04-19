<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Items;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class ManageRankItemsTest extends TestCase
{
    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageRankItemsPage()
    {
        $this->signInWithPermission('rank.create');

        $response = $this->get(route('ranks.items.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageRankItemsPage()
    {
        $this->signInWithPermission('rank.update');

        $response = $this->get(route('ranks.items.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageRankItemsPage()
    {
        $this->signInWithPermission('rank.delete');

        $response = $this->get(route('ranks.items.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageRankItemsPage()
    {
        $this->signInWithPermission('rank.view');

        $response = $this->get(route('ranks.items.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function rankItemsCanBeFilteredByRankName()
    {
        $this->signInWithPermission('rank.create');

        $group = RankGroup::factory()->create(['name' => 'Command']);
        $name = RankName::factory()->create(['name' => 'Captain']);

        RankItem::factory()->create([
            'group_id' => $group,
            'name_id' => $name,
        ]);
        RankItem::factory()->create(['group_id' => $group]);

        $response = $this->get(route('ranks.items.index'));
        $response->assertSuccessful();

        $this->assertEquals(RankItem::count(), $response['items']->total());

        $response = $this->get(route('ranks.items.index', 'search=captain'));
        $response->assertSuccessful();
        $response->assertSee('Captain');

        $this->assertCount(1, $response['items']);
    }

    /** @test **/
    public function rankItemsCanBeFilteredByRankGroup()
    {
        $this->signInWithPermission('rank.create');

        $command = RankGroup::factory()->create(['name' => 'Command']);
        $ops = RankGroup::factory()->create(['name' => 'Operations']);

        RankItem::factory()->create(['group_id' => $command]);
        RankItem::factory()->create(['group_id' => $command]);

        RankItem::factory()->create(['group_id' => $ops]);
        RankItem::factory()->create(['group_id' => $ops]);

        $response = $this->get(route('ranks.items.index'));
        $response->assertSuccessful();

        $this->assertEquals(RankItem::count(), $response['items']->total());

        $response = $this->get(route('ranks.items.index', 'group=command'));
        $response->assertSuccessful();

        $this->assertCount(2, $response['items']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageRankItemsPage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.items.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageRankItemsPage()
    {
        $response = $this->getJson(route('ranks.items.index'));
        $response->assertUnauthorized();
    }
}
