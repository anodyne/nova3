<?php

declare(strict_types=1);

use Nova\Users\Livewire\ForcePasswordResetButton;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('users');
uses()->group('components');

beforeEach(function () {
    signIn(permissions: 'user.update');

    $this->user = User::factory()->active()->create();
});

test('a user can be forced to reset their password with the button', function () {
    livewire(ForcePasswordResetButton::class)
        ->set('user', $this->user)
        ->call('forcePasswordReset');

    assertDatabaseHas(User::class, [
        'id' => $this->user->id,
        'force_password_reset' => true,
    ]);
});
