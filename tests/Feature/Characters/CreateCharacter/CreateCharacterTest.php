<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Characters\Events\CharacterCreated;
use Nova\Characters\Events\CharacterCreatedByAdmin;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Livewire\ManagePositions;
use Nova\Characters\Livewire\ManageUsers;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
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
use function Pest\Laravel\post;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('characters');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.create');
    });

    test('can view the create character page', function () {
        get(route('admin.characters.create'))->assertSuccessful();
    });

    test('can create a character', function () {
        Event::fake();

        $data = Character::factory()->make();

        from(route('admin.characters.create'))
            ->followingRedirects()
            ->post(route('admin.characters.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Character::class, Arr::only($data->toArray(), ['name']));

        Event::assertDispatched(CharacterCreated::class);
        Event::assertDispatched(CharacterCreatedByAdmin::class);
    });

    test('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, true)
            ->assertCanSeeTableRecords([$activeCharacter, $inactiveCharacter, $deletedCharacter])
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($deletedCharacter))
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

    test('cannot view the create character page', function () {
        get(route('admin.characters.create'))
            ->assertForbidden();
    });

    test('cannot create a character', function () {
        post(route('admin.characters.store'), [])
            ->assertForbidden();
    });

    test('has the correct permissions for list characters page', function () {
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
    test('cannot view the create character page', function () {
        get(route('admin.characters.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a character', function () {
        post(route('admin.characters.store'), [])
            ->assertRedirectToRoute('login');
    });
});

describe('character creation', function () {
    beforeEach(function () {
        signIn(permissions: 'character.create');
    });

    test('can assign users to a character when creating it', function () {
        $user = User::factory()->active()->create();

        $assignedUsers = livewire(ManageUsers::class)
            ->set('selected', (string) $user->id)
            ->get('assignedUsers');

        $data = array_merge(
            Character::factory()->make()->toArray(),
            ['assigned_users' => $assignedUsers]
        );

        from(route('admin.characters.create'))
            ->followingRedirects()
            ->post(route('admin.characters.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(Character::class, Arr::only($data, ['name']));

        assertDatabaseHas('character_user', [
            'user_id' => $user->id,
            'character_id' => Character::latest('id')->first()->id,
        ]);
    });

    test('can assign a primary user to a character when creating it', function () {
        $user = User::factory()->active()->create();

        $livewire = livewire(ManageUsers::class)
            ->set('selected', (string) $user->id)
            ->call('setPrimaryCharacterForUser', $user->id);

        $data = array_merge(
            Character::factory()->make()->toArray(),
            [
                'assigned_users' => $livewire->get('assignedUsers'),
                'primary_users' => $livewire->get('primaryUsers'),
            ]
        );

        from(route('admin.characters.create'))
            ->followingRedirects()
            ->post(route('admin.characters.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(Character::class, Arr::only($data, ['name']));

        assertDatabaseHas('character_user', [
            'user_id' => $user->id,
            'character_id' => Character::latest('id')->first()->id,
            'primary' => true,
        ]);
    });

    test('can assign positions to a character when creating it', function () {
        $position = Position::factory()->create();

        $assignedPositions = livewire(ManagePositions::class)
            ->set('selected', (string) $position->id)
            ->get('assignedPositions');

        $data = array_merge(
            Character::factory()->make()->toArray(),
            ['assigned_positions' => $assignedPositions]
        );

        from(route('admin.characters.create'))
            ->followingRedirects()
            ->post(route('admin.characters.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(Character::class, Arr::only($data, ['name']));

        assertDatabaseHas('character_position', [
            'position_id' => $position->id,
            'character_id' => Character::latest('id')->first()->id,
        ]);
    });

    test('can upload an avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('image.png'))
            ->get('path');

        $data = array_merge(
            Character::factory()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('admin.characters.create'))
            ->followingRedirects()
            ->post(route('admin.characters.store'), $data)
            ->assertSuccessful();

        $newCharacter = Character::latest('id')->first();

        assertCount(1, $newCharacter->getMedia('avatar'));
    })->skip();
});
