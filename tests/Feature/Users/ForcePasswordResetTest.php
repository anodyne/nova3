<?php

declare(strict_types=1);

use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\from;
use function Pest\Livewire\livewire;

uses()->group('users');

describe('force password reset from manage users page', function () {
    beforeEach(function () {
        signIn(permissions: 'user.update');

        $this->activeUser = User::factory()->active()->create();
        $this->inactiveUser = User::factory()->inactive()->create();
        $this->pendingUser = User::factory()->pending()->create();
    });

    test('an active user can be forced to update their password at next sign in', function () {
        livewire(UsersList::class)
            ->callTableBulkAction('force-password-reset', [$this->activeUser])
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->activeUser->id,
            'force_password_reset' => true,
        ]);
    });

    test('an inactive user can be forced to update their password at next sign in', function () {
        livewire(UsersList::class)
            ->callTableBulkAction('force-password-reset', [$this->inactiveUser])
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->inactiveUser->id,
            'force_password_reset' => true,
        ]);
    });

    test('a pending user cannot be forced to update their password at next sign in', function () {
        livewire(UsersList::class)
            ->callTableBulkAction('force-password-reset', [$this->pendingUser])
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->pendingUser->id,
            'force_password_reset' => false,
        ]);
    });
});

test('when flagged, a user is required to update their password at next sign in', function () {
    $user = User::factory()->active()->create();
    $user->update(['force_password_reset' => true]);

    from(route('login'))
        ->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ])
        ->assertRedirectToRoute('password.request')
        ->assertSessionHas('message', 'An admin has required that you to reset your password before you can continue.');

    assertGuest();
});
