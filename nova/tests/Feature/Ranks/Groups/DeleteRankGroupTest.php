<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupDeleted;
use Nova\Ranks\Models\RankGroup;
beforeEach(function () {
    $this->group = RankGroup::factory()->create();
});
test('authorized user can delete a rank group', function () {
    $this->signInWithPermission('rank.delete');

    $this->followingRedirects();

    $response = $this->delete(route('ranks.groups.destroy', $this->group));
    $response->assertSuccessful();

    $this->assertDatabaseMissing('rank_groups', $this->group->only('id'));
});
test('event is dispatched when rank group is deleted', function () {
    Event::fake();

    $this->signInWithPermission('rank.delete');

    $this->delete(route('ranks.groups.destroy', $this->group));

    Event::assertDispatched(RankGroupDeleted::class);
});
test('unauthorized user cannot delete a rank group', function () {
    $this->signIn();

    $response = $this->delete(route('ranks.groups.destroy', $this->group));
    $response->assertForbidden();
});
test('unauthenticated user cannot delete a rank group', function () {
    $response = $this->deleteJson(
        route('ranks.groups.destroy', $this->group)
    );
    $response->assertUnauthorized();
});
