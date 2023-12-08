<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Livewire\RolesList;
use Nova\Roles\Models\Role;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('roles');

beforeEach(function () {
    signIn(permissions: ['role.create', 'role.update']);
});

test('an authorized user can duplicate a role', function () {
    Event::fake();

    $role = Role::factory()->create();

    $data = [
        'display_name' => 'New role',
    ];

    livewire(RolesList::class)
        ->callTableAction(ReplicateAction::class, $role, data: $data)
        ->assertNotified();

    assertDatabaseHas(Role::class, $data);

    Event::assertDispatched(RoleDuplicated::class);
});

test('an authorized user cannot duplicate a locked role', function () {
    $role = Role::factory()->locked()->create();

    livewire(RolesList::class)
        ->assertTableActionHidden(ReplicateAction::class, $role);
});
