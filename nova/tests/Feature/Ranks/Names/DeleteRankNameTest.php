<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameDeleted;
use Nova\Ranks\Models\RankName;
beforeEach(function () {
    $this->name = RankName::factory()->create();
});
test('authorized user can delete a rank group', function () {
    $this->signInWithPermission('rank.delete');

    $this->followingRedirects();

    $response = $this->delete(route('ranks.names.destroy', $this->name));
    $response->assertSuccessful();

    $this->assertDatabaseMissing('rank_names', $this->name->only('id'));
});
test('event is dispatched when rank name is deleted', function () {
    Event::fake();

    $this->signInWithPermission('rank.delete');

    $this->delete(route('ranks.names.destroy', $this->name));

    Event::assertDispatched(RankNameDeleted::class);
});
test('unauthorized user cannot delete a rank name', function () {
    $this->signIn();

    $response = $this->delete(route('ranks.names.destroy', $this->name));
    $response->assertForbidden();
});
test('unauthenticated user cannot delete a rank name', function () {
    $response = $this->deleteJson(
        route('ranks.names.destroy', $this->name)
    );
    $response->assertUnauthorized();
});
