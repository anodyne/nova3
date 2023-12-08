<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Roles\Events\RoleDeleted;
use Nova\Roles\Livewire\RolesList;
use Nova\Roles\Models\Role;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('roles');

beforeEach(function () {
    signIn(permissions: 'role.delete');
});

test('an authorized user can delete a role', function () {
    Event::fake();

    $role = Role::factory()->create();

    livewire(RolesList::class)
        ->callTableAction(DeleteAction::class, $role)
        ->assertCanNotSeeTableRecords([$role])
        ->assertNotified();

    assertDatabaseMissing(Role::class, $role->toArray());

    Event::assertDispatched(RoleDeleted::class);
});

test('an authorized user cannot deleted a locked role', function () {
    $role = Role::factory()->locked()->create();

    livewire(RolesList::class)
        ->assertTableActionHidden(DeleteAction::class, $role);
});

test('an authorized user can bulk delete roles that are not locked', function () {
    $roles = Role::factory()
        ->count(2)
        ->sequence(
            ['is_locked' => true],
            ['is_locked' => false],
        )
        ->create();

    livewire(RolesList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $roles)
        ->assertNotified();

    assertDatabaseHas(Role::class, $roles[0]->toArray());
    assertDatabaseMissing(Role::class, $roles[1]->toArray());
});
