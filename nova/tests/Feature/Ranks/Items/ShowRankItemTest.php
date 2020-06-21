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
class ShowRankItemTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    protected $item;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = create(RankGroup::class);
        $this->name = create(RankName::class);
        $this->item = create(RankItem::class, [
            'group_id' => $this->group,
            'name_id' => $this->name,
        ]);
    }

    /** @test **/
    public function authorizedUserCanViewARankItem()
    {
        $this->signInWithPermission('rank.view');

        $response = $this->get(route('ranks.items.show', $this->item));
        $response->assertSuccessful();
        $response->assertViewHas('item', $this->item);
        $response->assertSee($this->group->name);
        $response->assertSee($this->name->name);
    }

    /** @test **/
    public function unauthorizedUserCannotViewARankItem()
    {
        $this->signIn();

        $response = $this->get(route('ranks.items.show', $this->item));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewARankItem()
    {
        $response = $this->getJson(route('ranks.items.show', $this->item));
        $response->assertUnauthorized();
    }
}
