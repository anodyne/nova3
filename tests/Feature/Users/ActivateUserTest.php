<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Users\Events\UserActivated;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'user.update');

        $this->user = User::factory()->inactive()->create();

        $this->character = Character::factory()
            ->hasAttached($this->user)
            ->inactive()
            ->create();
    });

    test('can activate an inactive user without their previous character', function () {
        Event::fake();

        livewire(UsersList::class)
            ->callTableAction('activate', $this->user, data: [
                'activate_previous_character' => false,
            ]);

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'status' => 'active',
        ]);

        assertDatabaseHas(Character::class, [
            'id' => $this->character->id,
            'status' => 'inactive',
        ]);

        Event::assertDispatched(UserActivated::class);
    });

    test('can activate an inactive user with their previous character', function () {
        Event::fake();

        livewire(UsersList::class)
            ->callTableAction('activate', $this->user, data: [
                'activate_previous_character' => true,
            ])
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'status' => 'active',
        ]);

        assertDatabaseHas(Character::class, [
            'id' => $this->character->id,
            'status' => 'active',
        ]);

        Event::assertDispatched(UserActivated::class);
    });
});
