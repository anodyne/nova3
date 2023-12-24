<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Users\Events\UserDeleted;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(function () {
        $this->users = User::factory()->count(5)->create();

        signIn(permissions: 'user.delete');
    });

    test('can delete a user', function () {
        Event::fake();

        livewire(UsersList::class)
            ->callTableAction(DeleteAction::class, $this->users->first())
            ->assertCanNotSeeTableRecords([$this->users->first()])
            ->assertNotified();

        assertDatabaseMissing(User::class, $this->users->first()->toArray());

        Event::assertDispatched(UserDeleted::class);
    });

    test('cannot delete their own account', function () {
        livewire(UsersList::class)
            ->assertTableActionHidden(DeleteAction::class, auth()->user());
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->assertTableHeaderActionsExistInOrder([])
            ->assertTableActionHidden(ViewAction::class, $activeUser)
            ->assertTableActionHidden(EditAction::class, $activeUser)
            ->assertTableActionVisible(DeleteAction::class, $activeUser)
            ->assertTableActionHidden('impersonate', $activeUser)
            ->assertTableActionHidden('activate', $activeUser)
            ->assertTableActionHidden('deactivate', $activeUser)
            ->assertTableActionHidden(ViewAction::class, $inactiveUser)
            ->assertTableActionHidden(EditAction::class, $inactiveUser)
            ->assertTableActionVisible(DeleteAction::class, $inactiveUser)
            ->assertTableActionHidden('impersonate', $inactiveUser)
            ->assertTableActionHidden('activate', $inactiveUser)
            ->assertTableActionHidden('deactivate', $inactiveUser);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot delete a user', function () {
        get(route('users.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot delete a user', function () {
        get(route('users.index'))->assertRedirectToRoute('login');
    });
});
