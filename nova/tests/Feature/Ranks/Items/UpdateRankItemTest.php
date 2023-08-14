<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemUpdated;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Requests\UpdateRankItemRequest;
beforeEach(function () {
    $this->item = RankItem::factory()->create();
});
test('authorized user can view the edit rank item page', function () {
    $this->signInWithPermission('rank.update');

    $response = $this->get(route('ranks.items.edit', $this->item));
    $response->assertSuccessful();
});
test('authorized user can update a rank item', function () {
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
});
test('event is dispatched when rank item is updated', function () {
    Event::fake();

    $this->signInWithPermission('rank.update');

    $this->put(
        route('ranks.items.update', $this->item),
        RankItem::factory()->make()->toArray()
    );

    Event::assertDispatched(RankItemUpdated::class);
});
test('unauthorized user cannot view the edit rank item page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.items.edit', $this->item));
    $response->assertForbidden();
});
test('unauthorized user cannot update a rank item', function () {
    $this->signIn();

    $response = $this->put(
        route('ranks.items.update', $this->item),
        RankItem::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit rank item page', function () {
    $response = $this->getJson(route('ranks.items.edit', $this->item));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update a rank item', function () {
    $response = $this->putJson(
        route('ranks.items.update', $this->item),
        RankItem::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
