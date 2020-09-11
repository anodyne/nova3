<?php

namespace Tests\Feature\Ranks\Items;

use Tests\TestCase;
use Nova\Ranks\Models\RankItem;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemUpdated;
use Nova\Ranks\Requests\UpdateRankItemRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class UpdateRankItemTest extends TestCase
{
    use RefreshDatabase;

    protected $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->item = RankItem::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewTheEditRankItemPage()
    {
        $this->signInWithPermission('rank.update');

        $response = $this->get(route('ranks.items.edit', $this->item));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateARankItem()
    {
        $this->signInWithPermission('rank.update');

        $this->followingRedirects();

        $response = $this->put(
            route('ranks.items.update', $this->item),
            $rankItemData = RankItem::factory()->make()->toArray()
        );
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'ranks.items.update',
            UpdateRankItemRequest::class
        );

        $this->assertDatabaseHas('rank_items', $rankItemData);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankItemIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('rank.update');

        $this->put(
            route('ranks.items.update', $this->item),
            RankItem::factory()->make()->toArray()
        );

        Event::assertDispatched(RankItemUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditRankItemPage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.items.edit', $this->item));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateARankItem()
    {
        $this->signIn();

        $response = $this->put(
            route('ranks.items.update', $this->item),
            RankItem::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditRankItemPage()
    {
        $response = $this->getJson(route('ranks.items.edit', $this->item));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateARankItem()
    {
        $response = $this->putJson(
            route('ranks.items.update', $this->item),
            RankItem::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
