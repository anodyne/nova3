<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemDeleted;
use Nova\Ranks\Models\RankItem;
beforeEach(function () {
    $this->item = RankItem::factory()->create();
});
test('authorized user can delete a rank item', function () {
    $this->signInWithPermission('rank.delete');

    $this->followingRedirects();

    $response = $this->delete(route('ranks.items.destroy', $this->item));
    $response->assertSuccessful();

    $this->assertDatabaseMissing('rank_items', $this->item->only('id'));
});
test('event is dispatched when rank item is deleted', function () {
    Event::fake();

    $this->signInWithPermission('rank.delete');

    $this->delete(route('ranks.items.destroy', $this->item));

    Event::assertDispatched(RankItemDeleted::class);
});
test('unauthorized user cannot delete a rank item', function () {
    $this->signIn();

    $response = $this->delete(route('ranks.items.destroy', $this->item));
    $response->assertForbidden();
});
test('unauthenticated user cannot delete a rank item', function () {
    $response = $this->deleteJson(
        route('ranks.items.destroy', $this->item)
    );
    $response->assertUnauthorized();
});
