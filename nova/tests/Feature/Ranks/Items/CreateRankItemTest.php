<?php

namespace Tests\Feature\Ranks\Items;

use Tests\TestCase;
use Nova\Ranks\Models\RankItem;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Http\Requests\CreateRankItemRequest;

/**
 * @group ranks
 */
class CreateRankItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreateRankItemPage()
    {
        $this->signInWithPermission('rank.create');

        $response = $this->get(route('ranks.items.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateARankItem()
    {
        $this->signInWithPermission('rank.create');

        $this->followingRedirects();

        $response = $this->post(
            route('ranks.items.store'),
            $rankItemData = make(RankItem::class)->toArray()
        );
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'ranks.items.store',
            CreateRankItemRequest::class
        );

        $this->assertDatabaseHas('rank_items', $rankItemData);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankItemIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('rank.create');

        $this->post(
            route('ranks.items.store'),
            make(RankItem::class)->toArray()
        );

        Event::assertDispatched(RankItemCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateRankItemPage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.items.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateARankItem()
    {
        $this->signIn();

        $response = $this->post(
            route('ranks.items.store'),
            make(RankItem::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateRankItemPage()
    {
        $response = $this->getJson(route('ranks.items.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateARankItem()
    {
        $response = $this->postJson(
            route('ranks.items.store'),
            make(RankItem::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
