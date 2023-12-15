<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Users\Events\UserDeleted;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('users');

beforeEach(function () {
    $this->users = User::factory()->count(5)->create();

    signIn(permissions: 'user.delete');
});

test('an authorized user can delete a user', function () {
    Event::fake();

    livewire(UsersList::class)
        ->callTableAction(DeleteAction::class, $this->users->first())
        ->assertCanNotSeeTableRecords([$this->users->first()])
        ->assertNotified();

    assertDatabaseMissing(User::class, $this->users->first()->toArray());

    Event::assertDispatched(UserDeleted::class);
});

test('an authorized user cannot delete their own account', function () {
    livewire(UsersList::class)
        ->assertTableActionHidden(DeleteAction::class, auth()->user());
});
