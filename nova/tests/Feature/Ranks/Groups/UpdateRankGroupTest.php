<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupUpdated;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Requests\UpdateRankGroupRequest;
beforeEach(function () {
    $this->group = RankGroup::factory()->create();
});
test('authorized user can view the edit rank group page', function () {
    $this->signInWithPermission('rank.update');

    $response = $this->get(route('ranks.groups.edit', $this->group));
    $response->assertSuccessful();
});
test('authorized user can update a rank group', function () {
    $this->signInWithPermission('rank.update');

    $this->followingRedirects();

    $response = $this->put(
        route('ranks.groups.update', $this->group),
        $rankGroupData = RankGroup::factory()->make()->toArray()
    );
    $response->assertSuccessful();

    $this->assertRouteUsesFormRequest(
        'ranks.groups.update',
        UpdateRankGroupRequest::class
    );

    $this->assertDatabaseHas('rank_groups', $rankGroupData);
});
test('event is dispatched when rank group is updated', function () {
    Event::fake();

    $this->signInWithPermission('rank.update');

    $this->put(
        route('ranks.groups.update', $this->group),
        RankGroup::factory()->make()->toArray()
    );

    Event::assertDispatched(RankGroupUpdated::class);
});
test('unauthorized user cannot view the edit rank group page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.groups.edit', $this->group));
    $response->assertForbidden();
});
test('unauthorized user cannot update a rank group', function () {
    $this->signIn();

    $response = $this->put(
        route('ranks.groups.update', $this->group),
        RankGroup::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit rank group page', function () {
    $response = $this->getJson(route('ranks.groups.edit', $this->group));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update a rank group', function () {
    $response = $this->putJson(
        route('ranks.groups.update', $this->group),
        RankGroup::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
