<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterUpdated;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->create();

    $position = Position::factory()->create();
    $user = User::factory()->create();

    $this->character->positions()->attach($position);
    $this->character->users()->attach($user);

    $this->character->refresh();
});
test('authorized user can view the edit character page', function () {
    $this->signInWithPermission('character.update');

    $response = $this->get(route('characters.edit', $this->character));
    $response->assertSuccessful();
});
test('authorized user can update a character', function () {
    $this->signInWithPermission('character.update');

    $this->followingRedirects();

    $rank = RankItem::factory()->create();

    $response = $this->put(route('characters.update', $this->character), [
        'name' => 'Jack Sparrow',
        'rank_id' => $rank->id,
        'positions' => $this->character->positions->pluck('id')->all(),
        'users' => $this->character->users->pluck('id')->all(),
    ]);
    $response->assertSuccessful();

    $character = Character::latest()->first();

    $this->assertDatabaseHas('characters', [
        'id' => $this->character->id,
        'name' => 'Jack Sparrow',
    ]);

    $this->assertDatabaseHas('character_position', [
        'character_id' => $character->id,
        'position_id' => $this->character->positions->first()->id,
    ]);

    $this->assertDatabaseHas('character_user', [
        'character_id' => $character->id,
        'user_id' => $this->character->users->first()->id,
    ]);

    $this->assertRouteUsesFormRequest(
        'characters.update',
        UpdateCharacterRequest::class
    );
});
test('events are dispatched when a character is updated', function () {
    Event::fake();

    $this->signInWithPermission('character.update');

    $rank = RankItem::factory()->create();

    $response = $this->put(route('characters.update', $this->character), [
        'name' => 'Jack Sparrow',
        'rank_id' => $rank->id,
        'positions' => $this->character->positions->pluck('id')->all(),
        'users' => $this->character->users->pluck('id')->all(),
    ]);

    Event::assertDispatched(CharacterUpdated::class);

    Event::assertDispatched(CharacterUpdatedByAdmin::class);
});
test('unauthorized user cannot view the edit character page', function () {
    $this->signIn();

    $response = $this->get(route('characters.edit', $this->character));
    $response->assertForbidden();
});
test('unauthorized user cannot update a character', function () {
    $this->signIn();

    $this->followingRedirects();

    $response = $this->put(route('characters.update', $this->character), [
        'name' => 'Jack Sparrow',
        'positions' => [1],
    ]);
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit character page', function () {
    $response = $this->getJson(route('characters.edit', $this->character));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update a character', function () {
    $response = $this->putJson(route('characters.update', $this->character), [
        'name' => 'Jack Sparrow',
        'positions' => [1],
    ]);
    $response->assertUnauthorized();
});
