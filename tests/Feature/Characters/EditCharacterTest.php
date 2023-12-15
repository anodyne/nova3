<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Characters\Events\CharacterUpdated;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Livewire\ManagePositions;
use Nova\Characters\Livewire\ManageUsers;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Media\Livewire\UploadAvatar;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.update');
    });

    test('can view the edit character page', function () {
        get(route('characters.edit', $this->character))
            ->assertSuccessful();
    });

    test('can update a character', function () {
        Event::fake();

        $data = Character::factory()->make();

        from(route('characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('characters.update', $this->character), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Character::class, [
            'id' => $this->character->id,
        ]);

        Event::assertDispatched(CharacterUpdated::class);
        Event::assertDispatched(CharacterUpdatedByAdmin::class);
    });

    test('can add a character avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('character-image.png'))
            ->get('path');

        $data = array_merge(
            Character::factory()->active()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('characters.update', $this->character), $data)
            ->assertSuccessful();

        $this->character->refresh();

        assertCount(1, $this->character->getMedia('avatar'));
    });

    test('can remove an uploaded character avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $this->character
            ->addMedia(base_path('tests/assets/image.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('avatar');

        assertCount(1, $this->character->getMedia('avatar'));

        from(route('characters.edit', $this->character))
            ->put(route('characters.update', $this->character), [
                'name' => $this->character->name,
                'remove_existing_image' => 'true',
            ]);

        $this->character->refresh();

        assertCount(0, $this->character->getMedia('avatar'));
    });

    test('can replace an uploaded character avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('character-image.png'))
            ->get('path');

        $data = array_merge(
            Character::factory()->active()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        assertCount(0, $this->character->getMedia('avatar'));

        from(route('characters.edit', $this->character))
            ->put(route('characters.update', $this->character), $data);

        $this->character->refresh();

        assertCount(1, $this->character->getMedia('avatar'));

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('character-image-2.png'))
            ->get('path');

        $data = array_merge(
            Character::factory()->active()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('characters.update', $this->character), $data)
            ->assertSuccessful();

        $this->character->refresh();

        assertCount(1, $this->character->getMedia('avatar'));
    });

    test('can assign users to a character', function () {
        $user = User::factory()->active()->create();

        $assignedUsers = livewire(ManageUsers::class)
            ->call('add', $user->id)
            ->get('assignedUsers');

        $data = array_merge(
            $this->character->toArray(),
            ['assigned_users' => $assignedUsers]
        );

        from(route('characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('characters.update', $this->character), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_user', [
            'user_id' => $user->id,
            'character_id' => $this->character->id,
        ]);
    });

    test('can assign a primary user to a character', function () {
        $user = User::factory()->active()->create();

        $livewire = livewire(ManageUsers::class)
            ->call('add', $user->id)
            ->call('setPrimaryCharacterForUser', $user->id);

        $data = array_merge(
            $this->character->toArray(),
            [
                'assigned_users' => $livewire->get('assignedUsers'),
                'primary_users' => $livewire->get('primaryUsers'),
            ]
        );

        from(route('characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('characters.update', $this->character), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_user', [
            'user_id' => $user->id,
            'character_id' => $this->character->id,
            'primary' => true,
        ]);
    });

    test('can assign positions to a character', function () {
        $position = Position::factory()->create();

        $assignedPositions = livewire(ManagePositions::class)
            ->call('add', $position->id)
            ->get('assignedPositions');

        $data = array_merge(
            $this->character->toArray(),
            ['assigned_positions' => $assignedPositions]
        );

        from(route('characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('characters.update', $this->character), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_position', [
            'position_id' => $position->id,
            'character_id' => $this->character->id,
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit character page', function () {
        get(route('characters.edit', $this->character))
            ->assertForbidden();
    });

    test('cannot update a character', function () {
        $data = Character::factory()->make();

        put(route('characters.update', $this->character), $data->toArray())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit character page', function () {
        get(route('characters.edit', $this->character))
            ->assertRedirect(route('login'));
    });

    test('cannot update a character', function () {
        put(route('characters.update', $this->character), [])
            ->assertRedirect(route('login'));
    });
});
