<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupCreated;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Requests\CreateRankGroupRequest;
test('authorized user can view the create rank group page', function () {
    $this->signInWithPermission('rank.create');

    $response = $this->get(route('ranks.groups.create'));
    $response->assertSuccessful();
});
test('authorized user can create a rank group', function () {
    $this->signInWithPermission('rank.create');

    $this->followingRedirects();

    $response = $this->post(
        route('ranks.groups.store'),
        $rankGroupData = RankGroup::factory()->make()->toArray()
    );
    $response->assertSuccessful();

    $this->assertRouteUsesFormRequest(
        'ranks.groups.store',
        CreateRankGroupRequest::class
    );

    $this->assertDatabaseHas('rank_groups', $rankGroupData);
});
test('event is dispatched when rank group is created', function () {
    Event::fake();

    $this->signInWithPermission('rank.create');

    $this->post(
        route('ranks.groups.store'),
        RankGroup::factory()->make()->toArray()
    );

    Event::assertDispatched(RankGroupCreated::class);
});
test('unauthorized user cannot view the create rank group page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.groups.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create a rank group', function () {
    $this->signIn();

    $response = $this->post(
        route('ranks.groups.store'),
        RankGroup::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the create rank group page', function () {
    $response = $this->getJson(route('ranks.groups.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create a rank group', function () {
    $response = $this->postJson(
        route('ranks.groups.store'),
        RankGroup::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
