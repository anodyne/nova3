<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
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
        $this->users = User::factory()->active()->count(5)->create();

        signIn(permissions: 'user.delete');
    });

    test('can delete a user', function () {
        Event::fake();

        livewire(UsersList::class)
            ->callAction(TestAction::make(DeleteAction::class)->table($this->users->first()))
            ->assertCanNotSeeTableRecords([$this->users->first()]);

        assertDatabaseMissing(User::class, $this->users->first()->toArray());

        Event::assertDispatched(UserDeleted::class);
    });

    test('cannot delete their own account', function () {
        livewire(UsersList::class)
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table(Auth::user()));
    });

    test('has the correct permissions for list users page', function () {
        $activeUser = User::factory()->active()->create();
        $inactiveUser = User::factory()->inactive()->create();

        livewire(UsersList::class)
            ->removeTableFilters()
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeUser))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($activeUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($activeUser))
            ->assertActionHidden(TestAction::make('activate')->table($activeUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($activeUser))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveUser))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($inactiveUser))
            ->assertActionHidden(TestAction::make('impersonate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('activate')->table($inactiveUser))
            ->assertActionHidden(TestAction::make('deactivate')->table($inactiveUser));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot delete a user', function () {
        get(route('admin.users.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot delete a user', function () {
        get(route('admin.users.index'))->assertRedirectToRoute('login');
    });
});
