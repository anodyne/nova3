<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Models\UserNotificationPreference;
use Nova\Media\Livewire\UploadAvatar;
use Nova\Roles\Models\Role;
use Nova\Users\Events\UserCreated;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;
use Nova\Users\Notifications\AccountCreated;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'user.create');
    });

    test('can view the create user page', function () {
        get(route('users.create'))->assertSuccessful();
    });

    test('can create a user', function () {
        Event::fake();

        $data = User::factory()->make();

        from(route('users.create'))
            ->followingRedirects()
            ->post(route('users.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(User::class, Arr::only($data->toArray(), ['name', 'email']));

        Event::assertDispatched(UserCreated::class);
        Event::assertDispatched(UserCreatedByAdmin::class);
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->assertTableActionHidden(ViewAction::class, $activeUser)
            ->assertTableActionHidden(EditAction::class, $activeUser)
            ->assertTableActionHidden(DeleteAction::class, $activeUser)
            ->assertTableActionHidden('impersonate', $activeUser)
            ->assertTableActionHidden('activate', $activeUser)
            ->assertTableActionHidden('deactivate', $activeUser)
            ->assertTableActionHidden(ViewAction::class, $inactiveUser)
            ->assertTableActionHidden(EditAction::class, $inactiveUser)
            ->assertTableActionHidden(DeleteAction::class, $inactiveUser)
            ->assertTableActionHidden('impersonate', $inactiveUser)
            ->assertTableActionHidden('activate', $inactiveUser)
            ->assertTableActionHidden('deactivate', $inactiveUser);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create user page', function () {
        get(route('users.create'))->assertForbidden();
    });

    test('cannot create a user', function () {
        post(route('users.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create user page', function () {
        get(route('users.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a user', function () {
        post(route('users.store'), [])
            ->assertRedirectToRoute('login');
    });
});

describe('user creation', function () {
    beforeEach(function () {
        signIn(permissions: 'user.create');
    });

    test('can send an email to the new user with their password', function () {
        Notification::fake();

        $data = User::factory()->make();

        from(route('users.create'))
            ->followingRedirects()
            ->post(route('users.store'), $data->toArray())
            ->assertSuccessful();

        $newUser = User::latest('id')->first();

        Notification::assertSentTo($newUser, AccountCreated::class);
    });

    test('can assign characters to a user when creating it', function () {
        $character = Character::factory()->create();

        $assignedCharacters = livewire(ManageCharacters::class)
            ->call('add', $character->id)
            ->get('assignedCharacters');

        $data = array_merge(
            User::factory()->make()->toArray(),
            ['assigned_characters' => $assignedCharacters]
        );

        from(route('users.create'))
            ->followingRedirects()
            ->post(route('users.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(User::class, Arr::only($data, ['name', 'email']));

        assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => User::latest('id')->first()->id,
        ]);
    });

    test('can assign a primary character to a user when creating it', function () {
        $character = Character::factory()->active()->create();

        $livewire = livewire(ManageCharacters::class)
            ->call('add', $character->id)
            ->call('setAsPrimaryCharacter', $character->id);

        $data = array_merge(
            User::factory()->make()->toArray(),
            [
                'assigned_characters' => $livewire->get('assignedCharacters'),
                'primary_character' => $livewire->get('primaryCharacter'),
            ]
        );

        from(route('users.create'))
            ->followingRedirects()
            ->post(route('users.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => User::latest('id')->first()->id,
            'primary' => true,
        ]);
    });

    test('can assign roles to a user when creating it', function () {
        $role = Role::first();

        $assignedRoles = livewire(ManageRoles::class)
            ->call('add', $role->id)
            ->get('assignedRoles');

        $data = array_merge(
            User::factory()->make()->toArray(),
            ['assigned_roles' => $assignedRoles]
        );

        from(route('users.create'))
            ->followingRedirects()
            ->post(route('users.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(User::class, Arr::only($data, ['name', 'email']));

        assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => User::latest('id')->first()->id,
        ]);
    });

    test('can upload an avatar', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadAvatar::class)
            ->set('image', UploadedFile::fake()->image('image.png'))
            ->get('path');

        $data = array_merge(
            User::factory()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('users.create'))
            ->followingRedirects()
            ->post(route('users.store'), $data)
            ->assertSuccessful();

        $newUser = User::latest('id')->first();

        assertCount(1, $newUser->getMedia('avatar'));
    });

    test('adds notification preferences for the user', function () {
        Event::fake();

        $data = User::factory()->make();

        from(route('users.create'))
            ->followingRedirects()
            ->post(route('users.store'), $data->toArray())
            ->assertSuccessful();

        $newUser = User::latest('id')->first();

        assertDatabaseHas(UserNotificationPreference::class, [
            'user_id' => $newUser->id,
        ]);
    });
});
