<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemCreated;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Requests\CreateRankItemRequest;
test('authorized user can view the create rank item page', function () {
    $this->signInWithPermission('rank.create');

    $response = $this->get(route('ranks.items.create'));
    $response->assertSuccessful();
});
test('authorized user can create a rank item', function () {
    $this->signInWithPermission('rank.create');

    $this->followingRedirects();

    $response = $this->post(
        route('ranks.items.store'),
        $rankItemData = RankItem::factory()->make()->toArray()
    );
    $response->assertSuccessful();

    $this->assertRouteUsesFormRequest(
        'ranks.items.store',
        CreateRankItemRequest::class
    );

    $this->assertDatabaseHas('rank_items', $rankItemData);
});
test('event is dispatched when rank item is created', function () {
    Event::fake();

    $this->signInWithPermission('rank.create');

    $this->post(
        route('ranks.items.store'),
        RankItem::factory()->make()->toArray()
    );

    Event::assertDispatched(RankItemCreated::class);
});
test('unauthorized user cannot view the create rank item page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.items.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create a rank item', function () {
    $this->signIn();

    $response = $this->post(
        route('ranks.items.store'),
        RankItem::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the create rank item page', function () {
    $response = $this->getJson(route('ranks.items.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create a rank item', function () {
    $response = $this->postJson(
        route('ranks.items.store'),
        RankItem::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
