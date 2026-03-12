<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
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

        get(route('admin.users.show', $activeUser))->assertSuccessful();
        get(route('admin.users.show', $inactiveUser))->assertSuccessful();
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->removeTableFilters()
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($activeUser))
            ->assertActionHidden(TestAction::make('activate')->table($activeUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($activeUser))
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('activate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($inactiveUser));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the view user page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        get(route('admin.users.show', $activeUser))->assertForbidden();
        get(route('admin.users.show', $inactiveUser))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view user page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        get(route('admin.users.show', $activeUser))->assertRedirectToRoute('login');
        get(route('admin.users.show', $inactiveUser))->assertRedirectToRoute('login');
    });
});
