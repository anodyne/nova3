<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Items;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemDeleted;
use Nova\Ranks\Models\RankItem;
use Tests\TestCase;

/**
 * @group ranks
 */
class DeleteRankItemTest extends TestCase
{
    use RefreshDatabase;

    protected $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->item = RankItem::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteARankItem()
    {
        $this->signInWithPermission('rank.delete');

        $this->followingRedirects();

        $response = $this->delete(route('ranks.items.destroy', $this->item));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('rank_items', $this->item->only('id'));
    }

    /** @test **/
    public function eventIsDispatchedWhenRankItemIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('rank.delete');

        $this->delete(route('ranks.items.destroy', $this->item));

        Event::assertDispatched(RankItemDeleted::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteARankItem()
    {
        $this->signIn();

        $response = $this->delete(route('ranks.items.destroy', $this->item));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteARankItem()
    {
        $response = $this->deleteJson(
            route('ranks.items.destroy', $this->item)
        );
        $response->assertUnauthorized();
    }
}
