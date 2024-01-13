<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertTrue;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'user.impersonate');
    });

    test('can enter impersonation', function () {
        $admin = Auth::user();

        $user = User::factory()->active()->create();

        get(route('impersonate', $user->id))
            ->assertRedirectToRoute('dashboard');

        assertTrue($user->isImpersonated());

        assertEquals(Auth::user()->getAuthIdentifier(), $user->id);

        assertDatabaseHas(Activity::class, [
            'event' => 'started impersonation',
            'subject_id' => $user->id,
            'subject_type' => 'user',
            'causer_id' => $admin->id,
            'causer_type' => 'user',
        ]);
    });

    test('can leave impersonation', function () {
        $admin = Auth::user();

        $user = User::factory()->active()->create();

        get(route('impersonate', $user->id));

        get(route('impersonate.leave'))->assertRedirectToRoute('users.index');

        assertFalse($user->isImpersonated());

        assertNotEquals(Auth::user()->getAuthIdentifier(), $user->id);

        assertDatabaseHas(Activity::class, [
            'event' => 'ended impersonation',
            'subject_id' => $user->id,
            'subject_type' => 'user',
            'causer_id' => $admin->id,
            'causer_type' => 'user',
        ]);
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->assertTableActionHidden(ViewAction::class, $activeUser)
            ->assertTableActionHidden(EditAction::class, $activeUser)
            ->assertTableActionHidden(DeleteAction::class, $activeUser)
            ->assertTableActionVisible('impersonate', $activeUser)
            ->assertTableActionHidden('activate', $activeUser)
            ->assertTableActionHidden('deactivate', $activeUser)
            ->assertTableActionHidden(ViewAction::class, $inactiveUser)
            ->assertTableActionHidden(EditAction::class, $inactiveUser)
            ->assertTableActionHidden(DeleteAction::class, $inactiveUser)
            ->assertTableActionVisible('impersonate', $inactiveUser)
            ->assertTableActionHidden('activate', $inactiveUser)
            ->assertTableActionHidden('deactivate', $inactiveUser);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot enter impersonation', function () {
        $admin = Auth::user();

        $user = User::factory()->active()->create();

        get(route('impersonate', $user->id))->assertForbidden();

        assertDatabaseMissing(Activity::class, [
            'event' => 'started impersonation',
            'subject_id' => $user->id,
            'subject_type' => 'user',
            'causer_id' => $admin->id,
            'causer_type' => 'user',
        ]);
    });

    test('cannot leave impersonation', function () {
        $admin = Auth::user();

        get(route('impersonate.leave'))->assertForbidden();

        assertDatabaseMissing(Activity::class, [
            'event' => 'ended impersonation',
            'causer_id' => $admin->id,
            'causer_type' => 'user',
        ]);
    });
});

describe('unauthenticated user', function () {
    test('cannot enter impersonation', function () {
        $user = User::factory()->active()->create();

        get(route('impersonate', $user->id))->assertRedirectToRoute('login');

        assertGuest();
    });

    test('cannot leave impersonation', function () {
        get(route('impersonate.leave'))->assertForbidden();

        assertGuest();
    });
});
