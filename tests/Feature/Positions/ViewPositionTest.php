<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;

use function Pest\Laravel\get;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->position = Position::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.view');
    });

    test('can view the view position page', function () {
        get(route('admin.positions.show', $this->position))->assertSuccessful();
    });

    test('show page displays position with no assigned characters', function () {
        $response = get(route('admin.positions.show', $this->position));

        $response->assertSuccessful();
        $response->assertSee($this->position->name);
        $response->assertSee($this->position->department->name);
    });

    test('show page displays assigned active characters', function () {
        $character = Character::factory()->active()->create();
        $character->positions()->sync([$this->position->id]);

        $response = get(route('admin.positions.show', $this->position));

        $response->assertSuccessful();
        $response->assertSee($character->name);
    });

    test('show page does not display assigned inactive characters', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();

        $activeCharacter->positions()->sync([$this->position->id]);
        $inactiveCharacter->positions()->sync([$this->position->id]);

        $response = get(route('admin.positions.show', $this->position));

        $response->assertSuccessful();
        $response->assertSee($activeCharacter->name);
        $response->assertDontSee($inactiveCharacter->name);
    });

    test('show page displays correct active characters count', function () {
        $activeCharacters = Character::factory()->active()->count(3)->create();
        $inactiveCharacter = Character::factory()->inactive()->create();

        foreach ($activeCharacters as $character) {
            $character->positions()->sync([$this->position->id]);
        }
        $inactiveCharacter->positions()->sync([$this->position->id]);

        $response = get(route('admin.positions.show', $this->position));

        $response->assertSuccessful();
        $response->assertSee('3');
    });

    test('show page displays correct active users count', function () {
        $user = User::factory()->active()->create();

        $characters = Character::factory()->count(2)->active()->create();

        foreach ($characters as $character) {
            $character->users()->attach($user);
            $character->positions()->sync([$this->position->id]);
        }

        $response = get(route('admin.positions.show', $this->position));

        $response->assertSuccessful();

        $this->position->refresh();

        expect($this->position->active_users_count)->toBe(1);
    });

    test('show page displays available slots', function () {
        $position = Position::factory()->create(['available' => 5]);

        $response = get(route('admin.positions.show', $position));

        $response->assertSuccessful();
        $response->assertSeeText('5');
        $response->assertSeeText('Available slots');
    });

    test('show page displays tags when present', function () {
        $position = Position::factory()->create([
            'tags' => ['tag1', 'tag2', 'tag3'],
        ]);

        $response = get(route('admin.positions.show', $position));

        $response->assertSuccessful();
        $response->assertSee('tag1');
        $response->assertSee('tag2');
        $response->assertSee('tag3');
    });

    test('show page does not error when no tags', function () {
        $position = Position::factory()->create(['tags' => null]);

        $response = get(route('admin.positions.show', $position));

        $response->assertSuccessful();
    });

    test('show page displays position status', function () {
        $activePosition = Position::factory()->active()->create();

        $response = get(route('admin.positions.show', $activePosition));

        $response->assertSuccessful();
        $response->assertSee('Active');
    });

    test('show page displays position description when present', function () {
        $position = Position::factory()->create([
            'description' => 'This is a test description',
        ]);

        $response = get(route('admin.positions.show', $position));

        $response->assertSuccessful();
        $response->assertSee('This is a test description');
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view position page', function () {
        get(route('admin.positions.show', $this->position))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view position page', function () {
        get(route('admin.positions.show', $this->position))
            ->assertRedirectToRoute('login');
    });
});
