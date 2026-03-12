<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('bans');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'ban.create'));

    test('can view the create ban page', function () {
        get(route('admin.bans.create'))
            ->assertSuccessful();
    });

    test('can create a permanent user ban', function () {
        $user = User::factory()->create();

        from(route('admin.bans.create'))
            ->followingRedirects()
            ->post(route('admin.bans.store'), [
                'bannable_id' => $user->id,
                'comment' => 'Reason for banning',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Ban::class, [
            'bannable_id' => $user->id,
            'bannable_type' => $user->getMorphClass(),
            'created_by_id' => Auth::id(),
            'created_by_type' => Auth::user()->getMorphClass(),
            'comment' => 'Reason for banning',
            'ip' => null,
            'expired_at' => null,
        ]);
    });

    test('can create an expiring user ban', function () {
        $user = User::factory()->create();

        from(route('admin.bans.create'))
            ->followingRedirects()
            ->post(route('admin.bans.store'), [
                'bannable_id' => $user->id,
                'comment' => 'Reason for banning',
                'expired_at' => '2025-11-01',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Ban::class, [
            'bannable_id' => $user->id,
            'bannable_type' => $user->getMorphClass(),
            'created_by_id' => Auth::id(),
            'created_by_type' => Auth::user()->getMorphClass(),
            'comment' => 'Reason for banning',
            'ip' => null,
            'expired_at' => Date::createFromDate(2025, 11, 01)->startOfDay(),
        ]);
    });

    test('can create a permanent IP address ban', function () {
        from(route('admin.bans.create'))
            ->followingRedirects()
            ->post(route('admin.bans.store'), [
                'ip' => '1.1.1.1',
                'comment' => 'Reason for banning',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Ban::class, [
            'bannable_id' => null,
            'bannable_type' => null,
            'created_by_id' => Auth::id(),
            'created_by_type' => Auth::user()->getMorphClass(),
            'comment' => 'Reason for banning',
            'ip' => '1.1.1.1',
            'expired_at' => null,
        ]);
    });

    test('can create an expiring IP address ban', function () {
        from(route('admin.bans.create'))
            ->followingRedirects()
            ->post(route('admin.bans.store'), [
                'ip' => '1.1.1.1',
                'comment' => 'Reason for banning',
                'expired_at' => '2025-11-01',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Ban::class, [
            'bannable_id' => null,
            'bannable_type' => null,
            'created_by_id' => Auth::id(),
            'created_by_type' => Auth::user()->getMorphClass(),
            'comment' => 'Reason for banning',
            'ip' => '1.1.1.1',
            'expired_at' => Date::createFromDate(2025, 11, 01)->startOfDay(),
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the create ban page', function () {
        get(route('admin.bans.create'))
            ->assertForbidden();
    });

    test('cannot create a ban', function () {
        from(route('admin.bans.create'))
            ->followingRedirects()
            ->post(route('admin.bans.store'), [])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create ban page', function () {
        get(route('admin.bans.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a ban', function () {
        post(route('admin.bans.store'), [])
            ->assertRedirectToRoute('login');
    });
});
