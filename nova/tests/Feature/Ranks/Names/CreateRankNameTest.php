<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameCreated;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\CreateRankNameRequest;
test('authorized user can view the create rank name page', function () {
    $this->signInWithPermission('rank.create');

    $response = $this->get(route('ranks.names.create'));
    $response->assertSuccessful();
});
test('authorized user can create a rank name', function () {
    $this->signInWithPermission('rank.create');

    $this->followingRedirects();

    $response = $this->post(
        route('ranks.names.store'),
        $rankNameData = RankName::factory()->make()->toArray()
    );
    $response->assertSuccessful();

    $this->assertRouteUsesFormRequest(
        'ranks.names.store',
        CreateRankNameRequest::class
    );

    $this->assertDatabaseHas('rank_names', $rankNameData);
});
test('event is dispatched when rank name is created', function () {
    Event::fake();

    $this->signInWithPermission('rank.create');

    $this->post(
        route('ranks.names.store'),
        RankName::factory()->make()->toArray()
    );

    Event::assertDispatched(RankNameCreated::class);
});
test('unauthorized user cannot view the create rank name page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.names.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create a rank name', function () {
    $this->signIn();

    $response = $this->post(
        route('ranks.names.store'),
        RankName::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the create rank name page', function () {
    $response = $this->getJson(route('ranks.names.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create a rank name', function () {
    $response = $this->postJson(
        route('ranks.names.store'),
        RankName::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
