<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Characters\Models\Character;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Media\Livewire\UploadAvatar;
use Nova\Roles\Models\Role;
use Nova\Users\Events\UserUpdated;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('users');

beforeEach(function () {
    $this->user = User::factory()->create();

    FormSubmission::factory()->userBio()->create([
        'owner_id' => $this->user->id,
        'owner_type' => 'user',
    ]);
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'user.update'));

    test('can view the edit user page', function () {
        get(route('admin.users.edit', $this->user))->assertSuccessful();
    });

    test('can update a user', function () {
        Event::fake();

        $data = User::factory()->make();

        from(route('admin.users.edit', $this->user))
            ->followingRedirects()
            ->put(route('admin.users.update', $this->user), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'email' => $data->email,
        ]);

        Event::assertDispatched(UserUpdated::class);
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->removeTableFilters()
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeUser))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($activeUser))
            ->assertActionHidden(TestAction::make('activate')->table($activeUser))
            ->assertActionVisible(TestAction::make('deactivate')->table($activeUser))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveUser))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($inactiveUser))
            ->assertActionVisible(TestAction::make('activate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($inactiveUser));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the edit user page', function () {
        get(route('admin.users.edit', $this->user))
            ->assertForbidden();
    });

    test('cannot update a user', function () {
        $data = User::factory()->make();

        put(route('admin.users.update', $this->user), $data->toArray())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit user page', function () {
        get(route('admin.users.edit', $this->user))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a user', function () {
        put(route('admin.users.update', $this->user), [])
            ->assertRedirectToRoute('login');
    });
});

describe('user updates', function () {
    beforeEach(fn () => signIn(permissions: 'user.update'));

    test('can add a user avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('user-image.png'))
            ->get('path');

        $data = array_merge(
            User::factory()->active()->make()->toArray(),
            [
                'image_path' => $imagePath,
                'assigned_characters' => '',
                'assigned_roles' => '',
            ]
        );

        from(route('admin.users.edit', $this->user))
            ->followingRedirects()
            ->put(route('admin.users.update', $this->user), $data)
            ->assertSuccessful();

        $this->user->refresh();

        assertCount(1, $this->user->getMedia('avatar'));
    })->skip();

    test('can remove an uploaded user avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $this->user
            ->addMedia(base_path('tests/assets/image.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('avatar');

        assertCount(1, $this->user->getMedia('avatar'));

        from(route('admin.users.edit', $this->user))
            ->put(route('admin.users.update', $this->user), [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'pronouns' => ['value' => 'none'],
                'remove_existing_image' => 'true',
            ]);

        $this->user->refresh();

        assertCount(0, $this->user->getMedia('avatar'));
    })->skip();

    test('can replace an uploaded user avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('user-image.png'))
            ->get('path');

        $data = array_merge(
            User::factory()->active()->make()->toArray(),
            [
                'image_path' => $imagePath,
                'assigned_characters' => '',
                'assigned_roles' => '',
            ]
        );

        assertCount(0, $this->user->getMedia('avatar'));

        from(route('admin.users.edit', $this->user))
            ->put(route('admin.users.update', $this->user), $data);

        $this->user->refresh();

        assertCount(1, $this->user->getMedia('avatar'));

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('user-image-2.png'))
            ->get('path');

        $data = array_merge(
            User::factory()->active()->make()->toArray(),
            [
                'image_path' => $imagePath,
                'assigned_characters' => '',
                'assigned_roles' => '',
            ]
        );

        from(route('admin.users.edit', $this->user))
            ->followingRedirects()
            ->put(route('admin.users.update', $this->user), $data)
            ->assertSuccessful();

        $this->user->refresh();

        assertCount(1, $this->user->getMedia('avatar'));
    })->skip();

    test('can assign characters to a user', function () {
        $character = Character::factory()->create();

        $assignedCharacters = livewire(ManageCharacters::class)
            ->set('selected', $character->id)
            ->get('assignedCharacters');

        $data = array_merge(
            $this->user->toArray(),
            ['assigned_characters' => $assignedCharacters]
        );

        from(route('admin.users.edit', $this->user))
            ->followingRedirects()
            ->put(route('admin.users.update', $this->user), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => $this->user->id,
        ]);
    });

    test('can assign a primary character to a user', function () {
        $character = Character::factory()->active()->create();

        $livewire = livewire(ManageCharacters::class)
            ->set('selected', $character->id)
            ->call('setAsPrimaryCharacter', $character->id);

        $data = array_merge(
            $this->user->toArray(),
            [
                'assigned_characters' => $livewire->get('assignedCharacters'),
                'primary_character' => $livewire->get('primaryCharacter'),
            ]
        );

        from(route('admin.users.edit', $this->user))
            ->followingRedirects()
            ->put(route('admin.users.update', $this->user), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => $this->user->id,
            'primary' => true,
        ]);
    });

    test('can assign roles to a user', function () {
        $role = Role::first();

        $assignedRoles = livewire(ManageRoles::class)
            ->set('assigned', [$role->id])
            ->get('assigned');

        $data = array_merge(
            $this->user->toArray(),
            ['assigned_roles' => implode(',', $assignedRoles)]
        );

        from(route('admin.users.edit', $this->user))
            ->followingRedirects()
            ->put(route('admin.users.update', $this->user), $data)
            ->assertSuccessful();

        assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $this->user->id,
        ]);
    });
});
