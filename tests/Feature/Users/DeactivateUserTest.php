<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Users\Events\UserDeactivated;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'user.update');

        $this->user = User::factory()->active()->create();

        $this->character = Character::factory()
            ->hasAttached($this->user)
            ->active()
            ->create();
    });

    test('an active user can be deactivated', function () {
        Event::fake();

        livewire(UsersList::class)
            ->callTableAction('deactivate', $this->user);

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'status' => 'inactive',
        ]);

        assertDatabaseHas(Character::class, [
            'id' => $this->character->id,
            'status' => 'inactive',
        ]);

        Event::assertDispatched(UserDeactivated::class);
    });

    test('a character with multiple users remains active if only one user is deactivated', function () {
        $user = User::factory()->active()->create();

        $user->characters()->attach($this->character->id);

        livewire(UsersList::class)
            ->callTableAction('deactivate', $this->user)
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'status' => 'inactive',
        ]);

        assertDatabaseHas(User::class, [
            'id' => $user->id,
            'status' => 'active',
        ]);

        assertDatabaseHas(Character::class, [
            'id' => $this->character->id,
            'status' => 'active',
        ]);
    });
});
