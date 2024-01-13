<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'user.view');
    });

    test('can view the view user page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        get(route('users.show', $activeUser))->assertSuccessful();
        get(route('users.show', $inactiveUser))->assertSuccessful();
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->assertTableActionVisible(ViewAction::class, $activeUser)
            ->assertTableActionHidden(EditAction::class, $activeUser)
            ->assertTableActionHidden(DeleteAction::class, $activeUser)
            ->assertTableActionHidden('impersonate', $activeUser)
            ->assertTableActionHidden('activate', $activeUser)
            ->assertTableActionHidden('deactivate', $activeUser)
            ->assertTableActionVisible(ViewAction::class, $inactiveUser)
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

    test('cannot view the view user page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        get(route('users.show', $activeUser))->assertForbidden();
        get(route('users.show', $inactiveUser))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view user page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        get(route('users.show', $activeUser))->assertRedirectToRoute('login');
        get(route('users.show', $inactiveUser))->assertRedirectToRoute('login');
    });
});
