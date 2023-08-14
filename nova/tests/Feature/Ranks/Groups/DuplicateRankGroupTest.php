<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Ranks\Models\RankGroup;
beforeEach(function () {
    $this->group = RankGroup::factory()
        ->hasRanks(1, function (array $attributes, RankGroup $group) {
            return ['group_id' => $group->id];
        })->create([
            'name' => 'Command',
        ]);
});
test('authorized user can duplicate rank group', function () {
    $this->signInWithPermission(['rank.create', 'rank.update']);

    $this->followingRedirects();

    $response = $this->post(
        route('ranks.groups.duplicate', $this->group),
        ['name' => 'New Name', 'base_image' => 'foo.png']
    );
    $response->assertSuccessful();

    $newGroup = RankGroup::get()->last();

    $this->assertDatabaseHas('rank_groups', [
        'name' => 'New Name',
    ]);

    $this->assertDatabaseHas('rank_items', [
        'group_id' => $newGroup->id,
        'base_image' => 'foo.png',
    ]);
});
test('event is dispatched when rank group is duplicated', function () {
    Event::fake();

    $this->signInWithPermission(['rank.create', 'rank.update']);

    $this->post(
        route('ranks.groups.duplicate', $this->group),
        ['name' => 'New Name', 'base_image' => 'foo.png']
    );

    Event::assertDispatched(RankGroupDuplicated::class);
});
test('unauthorized user cannot duplicate rank group', function () {
    $this->signIn();

    $response = $this->post(route('ranks.groups.duplicate', $this->group));
    $response->assertForbidden();
});
test('unauthenticated user cannot duplicate rank group', function () {
    $response = $this->postJson(
        route('ranks.groups.duplicate', $this->group)
    );
    $response->assertUnauthorized();
});
