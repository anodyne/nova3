<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterCreated;
use Nova\Characters\Events\CharacterCreatedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\StoreCharacterRequest;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;

uses()->group('characters');

test('user can view the create character page', function () {
    $this->signInWithPermission('character.create');

    $response = $this->get(route('characters.create'));
    $response->assertSuccessful();
});
test('user can create a character', function () {
    $this->signInWithPermission('character.create');

    $position = Position::factory()->create();
    $rank = RankItem::factory()->create();
    $user = User::factory()->active()->create();

    $this->followingRedirects();

    $response = $this->post(route('characters.store'), [
        'name' => 'Jack Sparrow',
        'rank_id' => $rank->id,
        'assigned_positions' => (string) $position->id,
        'assigned_users' => (string) $user->id,
        'primary_users' => null,
    ]);
    $response->assertSuccessful();

    $character = Character::latest()->first();

    $this->assertDatabaseHas('characters', [
        'name' => 'Jack Sparrow',
    ]);

    $this->assertDatabaseHas('character_position', [
        'character_id' => $character->id,
        'position_id' => $position->id,
    ]);

    $this->assertDatabaseHas('character_user', [
        'character_id' => $character->id,
        'user_id' => $user->id,
    ]);

    $this->assertRouteUsesFormRequest(
        'characters.store',
        StoreCharacterRequest::class
    );
});
test('events are dispatched when a character is created', function () {
    $this->withoutExceptionHandling();
    Event::fake();

    $this->signInWithPermission('character.create');

    $response = $this->post(route('characters.store'), [
        'name' => 'Jack Sparrow',
    ]);

    Event::assertDispatched(CharacterCreated::class);

    Event::assertDispatched(CharacterCreatedByAdmin::class);
});
test('unauthenticated user cannot view the create character page', function () {
    $response = $this->getJson(route('characters.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create a character', function () {
    $response = $this->postJson(route('characters.store'), [
        'name' => 'Jack Sparrow',
    ]);
    $response->assertUnauthorized();
});
test('unauthorized user cannot view the create character page', function () {
    $this->signIn();

    $this->followingRedirects();

    $response = $this->get(route('characters.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create a character', function () {
    $this->signIn();

    $this->followingRedirects();

    $response = $this->post(route('characters.store'), [
        'name' => 'Jack Sparrow',
    ]);
    $response->assertForbidden();
});
