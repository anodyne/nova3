<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Models\Activity;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

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
            ->assertRedirectToRoute('admin.dashboard');

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

        get(route('impersonate.leave'))->assertRedirectToRoute('admin.users.index');

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
            ->removeTableFilters()
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeUser))
            ->assertActionVisible(TestAction::make('impersonate')->table($activeUser))
            ->assertActionHidden(TestAction::make('activate')->table($activeUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($activeUser))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveUser))
            ->assertActionVisible(TestAction::make('impersonate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('activate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($inactiveUser));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

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
