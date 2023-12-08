<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Nova\Foundation\Models\UserNotificationPreference;
use Nova\Users\Events\UserCreated;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Models\User;
use Nova\Users\Notifications\AccountCreated;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

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

    test('can add roles for the user', function () {
    })->todo();

    test('can add characters for the user', function () {
    })->todo();

    test('can upload an avatar', function () {
    })->todo();

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
            ->assertRedirect(route('login'));
    });

    test('cannot create a user', function () {
        post(route('users.store'), [])
            ->assertRedirect(route('login'));
    });
});
