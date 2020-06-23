<?php

namespace Tests\Feature\Ranks\Items;

use Tests\TestCase;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class ManageRankItemsTest extends TestCase
{
    use RefreshDatabase;

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

        $group = create(RankGroup::class, ['name' => 'Command']);
        $name = create(RankName::class, ['name' => 'Captain']);

        create(RankItem::class, [
            'group_id' => $group,
            'name_id' => $name,
        ]);
        create(RankItem::class, ['group_id' => $group]);

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

        $command = create(RankGroup::class, ['name' => 'Command']);
        $ops = create(RankGroup::class, ['name' => 'Operations']);

        create(RankItem::class, ['group_id' => $command]);
        create(RankItem::class, ['group_id' => $command]);

        create(RankItem::class, ['group_id' => $ops]);
        create(RankItem::class, ['group_id' => $ops]);

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
