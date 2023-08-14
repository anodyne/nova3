<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameUpdated;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\UpdateRankNameRequest;
beforeEach(function () {
    $this->name = RankName::factory()->create();
});
test('authorized user can view the edit rank name page', function () {
    $this->signInWithPermission('rank.update');

    $response = $this->get(route('ranks.names.edit', $this->name));
    $response->assertSuccessful();
});
test('authorized user can update a rank name', function () {
    $this->signInWithPermission('rank.update');

    $this->followingRedirects();

    $response = $this->put(
        route('ranks.names.update', $this->name),
        $rankNameData = RankName::factory()->make()->toArray()
    );
    $response->assertSuccessful();

    $this->assertRouteUsesFormRequest(
        'ranks.names.update',
        UpdateRankNameRequest::class
    );

    $this->assertDatabaseHas('rank_names', $rankNameData);
});
test('event is dispatched when rank name is updated', function () {
    Event::fake();

    $this->signInWithPermission('rank.update');

    $this->put(
        route('ranks.names.update', $this->name),
        RankName::factory()->make()->toArray()
    );

    Event::assertDispatched(RankNameUpdated::class);
});
test('unauthorized user cannot view the edit rank name page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.names.edit', $this->name));
    $response->assertForbidden();
});
test('unauthorized user cannot update a rank name', function () {
    $this->signIn();

    $response = $this->put(
        route('ranks.names.update', $this->name),
        RankName::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit rank name page', function () {
    $response = $this->getJson(route('ranks.names.edit', $this->name));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update a rank name', function () {
    $response = $this->putJson(
        route('ranks.names.update', $this->name),
        RankName::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
