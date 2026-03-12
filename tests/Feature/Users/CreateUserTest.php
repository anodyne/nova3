<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Media\Livewire\UploadAvatar;
use Nova\Roles\Models\Role;
use Nova\Users\Events\UserCreated;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;
use Nova\Users\Models\UserNotificationPreference;
use Nova\Users\Notifications\AccountCreated;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'user.create'));

    test('can view the create user page', function () {
        get(route('admin.users.create'))->assertSuccessful();
    });

    test('can create a user', function () {
        Event::fake();

        $data = User::factory()->make();

        from(route('admin.users.create'))
            ->followingRedirects()
            ->post(route('admin.users.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(User::class, Arr::only($data->toArray(), ['name', 'email']));

        Event::assertDispatched(UserCreated::class);
        Event::assertDispatched(UserCreatedByAdmin::class);
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->removeTableFilters()
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($activeUser))
            ->assertActionHidden(TestAction::make('activate')->table($activeUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($activeUser))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('activate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($inactiveUser));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the create user page', function () {
        get(route('admin.users.create'))->assertForbidden();
    });

    test('cannot create a user', function () {
        post(route('admin.users.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create user page', function () {
        get(route('admin.users.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a user', function () {
        post(route('admin.users.store'), [])
            ->assertRedirectToRoute('login');
    });
});

describe('user creation', function () {
    beforeEach(fn () => signIn(permissions: 'user.create'));

    test('can send an email to the new user with their password', function () {
        Notification::fake();

        $data = User::factory()->make();

        from(route('admin.users.create'))
            ->followingRedirects()
            ->post(route('admin.users.store'), $data->toArray())
            ->assertSuccessful();

        $newUser = User::latest('id')->first();

        Notification::assertSentTo($newUser, AccountCreated::class);
    });

    test('can assign characters to a user when creating it', function () {
        $character = Character::factory()->create();

        $assignedCharacters = livewire(ManageCharacters::class)
            ->set('selected', $character->id)
            ->get('assignedCharacters');

        $data = array_merge(
            User::factory()->make()->toArray(),
            ['assigned_characters' => $assignedCharacters]
        );

        from(route('admin.users.create'))
            ->followingRedirects()
            ->post(route('admin.users.store'), $data)
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
            ->set('selected', $character->id)
            ->call('setAsPrimaryCharacter', $character->id);

        $data = array_merge(
            User::factory()->make()->toArray(),
            [
                'assigned_characters' => $livewire->get('assignedCharacters'),
                'primary_character' => $livewire->get('primaryCharacter'),
            ]
        );

        from(route('admin.users.create'))
            ->followingRedirects()
            ->post(route('admin.users.store'), $data)
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
            ->set('assigned', [$role->id])
            ->get('assigned');

        $data = array_merge(
            User::factory()->make()->toArray(),
            ['assigned_roles' => implode(',', $assignedRoles)]
        );

        from(route('admin.users.create'))
            ->followingRedirects()
            ->post(route('admin.users.store'), $data)
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

        from(route('admin.users.create'))
            ->followingRedirects()
            ->post(route('admin.users.store'), $data)
            ->assertSuccessful();

        $newUser = User::latest('id')->first();

        assertCount(1, $newUser->getMedia('avatar'));
    });

    test('adds notification preferences for the user', function () {
        Event::fake();

        $data = User::factory()->make();

        from(route('admin.users.create'))
            ->followingRedirects()
            ->post(route('admin.users.store'), $data->toArray())
            ->assertSuccessful();

        $newUser = User::latest('id')->first();

        assertDatabaseHas(UserNotificationPreference::class, [
            'user_id' => $newUser->id,
        ]);
    });
});
