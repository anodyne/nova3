<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Characters\Events\CharacterUpdated;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Livewire\ManagePositions;
use Nova\Characters\Livewire\ManageUsers;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\ViewAction;
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

    FormSubmission::factory()->characterBio()->create([
        'owner_id' => $this->character,
        'owner_type' => 'character',
    ]);
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.update');
    });

    test('can view the edit character page', function () {
        get(route('admin.characters.edit', $this->character))
            ->assertSuccessful();
    });

    test('can update a character', function () {
        Event::fake();

        $data = Character::factory()->make();

        from(route('admin.characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('admin.characters.update', $this->character), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Character::class, $this->character->only('id'));

        Event::assertDispatched(CharacterUpdated::class);
        Event::assertDispatched(CharacterUpdatedByAdmin::class);
    });

    it('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, true)
            ->assertCanSeeTableRecords([$activeCharacter, $inactiveCharacter, $deletedCharacter])
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeCharacter))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveCharacter))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($deletedCharacter))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($deletedCharacter));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit character page', function () {
        get(route('admin.characters.edit', $this->character))
            ->assertForbidden();
    });

    test('cannot update a character', function () {
        $data = Character::factory()->make();

        put(route('admin.characters.update', $this->character), $data->toArray())
            ->assertForbidden();
    });

    it('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, true)
            ->assertCanNotSeeTableRecords([$activeCharacter, $inactiveCharacter, $deletedCharacter]);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit character page', function () {
        get(route('admin.characters.edit', $this->character))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a character', function () {
        put(route('admin.characters.update', $this->character), [])
            ->assertRedirectToRoute('login');
    });
});

describe('character update', function () {
    beforeEach(function () {
        signIn(permissions: 'character.update');
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

        from(route('admin.characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('admin.characters.update', $this->character), $data)
            ->assertSuccessful();

        $this->character->refresh();

        assertCount(1, $this->character->getMedia('avatar'));
    })->skip();

    test('can remove an uploaded character avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $this->character
            ->addMedia(base_path('tests/assets/image.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('avatar');

        assertCount(1, $this->character->getMedia('avatar'));

        from(route('admin.characters.edit', $this->character))
            ->put(route('admin.characters.update', $this->character), [
                'name' => $this->character->name,
                'remove_existing_image' => 'true',
            ]);

        $this->character->refresh();

        assertCount(0, $this->character->getMedia('avatar'));
    })->skip();

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

        from(route('admin.characters.edit', $this->character))
            ->put(route('admin.characters.update', $this->character), $data);

        $this->character->refresh();

        assertCount(1, $this->character->getMedia('avatar'));

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('character-image-2.png'))
            ->get('path');

        $data = array_merge(
            Character::factory()->active()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('admin.characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('admin.characters.update', $this->character), $data)
            ->assertSuccessful();

        $this->character->refresh();

        assertCount(1, $this->character->getMedia('avatar'));
    })->skip();

    test('can assign users to a character', function () {
        $user = User::factory()->active()->create();

        $assignedUsers = livewire(ManageUsers::class)
            ->set('selected', (string) $user->id)
            ->get('assignedUsers');

        $data = array_merge(
            $this->character->toArray(),
            ['assigned_users' => $assignedUsers]
        );

        from(route('admin.characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('admin.characters.update', $this->character), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_user', [
            'user_id' => $user->id,
            'character_id' => $this->character->id,
        ]);
    });

    test('can assign a primary user to a character', function () {
        $user = User::factory()->active()->create();

        $livewire = livewire(ManageUsers::class)
            ->set('selected', (string) $user->id)
            ->call('setPrimaryCharacterForUser', $user->id);

        $data = array_merge(
            $this->character->toArray(),
            [
                'assigned_users' => $livewire->get('assignedUsers'),
                'primary_users' => $livewire->get('primaryUsers'),
            ]
        );

        from(route('admin.characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('admin.characters.update', $this->character), $data)
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
            ->set('selected', (string) $position->id)
            ->get('assignedPositions');

        $data = array_merge(
            $this->character->toArray(),
            ['assigned_positions' => $assignedPositions]
        );

        from(route('admin.characters.edit', $this->character))
            ->followingRedirects()
            ->put(route('admin.characters.update', $this->character), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_position', [
            'position_id' => $position->id,
            'character_id' => $this->character->id,
        ]);
    });
});
