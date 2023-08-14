<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameDuplicated;
use Nova\Ranks\Models\RankName;
beforeEach(function () {
    $this->name = RankName::factory()->create([
        'name' => 'Captain',
    ]);
});
test('authorized user can duplicate rank name', function () {
    $this->signInWithPermission(['rank.create', 'rank.update']);

    $this->followingRedirects();

    $response = $this->post(route('ranks.names.duplicate', $this->name));
    $response->assertSuccessful();

    $this->assertDatabaseHas('rank_names', [
        'name' => "Copy of {$this->name->name}",
    ]);
});
test('event is dispatched when rank name is duplicated', function () {
    Event::fake();

    $this->signInWithPermission(['rank.create', 'rank.update']);

    $this->post(route('ranks.names.duplicate', $this->name));

    Event::assertDispatched(RankNameDuplicated::class);
});
test('unauthorized user cannot duplicate rank name', function () {
    $this->signIn();

    $response = $this->post(route('ranks.names.duplicate', $this->name));
    $response->assertForbidden();
});
test('unauthenticated user cannot duplicate rank name', function () {
    $response = $this->postJson(
        route('ranks.names.duplicate', $this->name)
    );
    $response->assertUnauthorized();
});
