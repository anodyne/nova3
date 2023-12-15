<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Users\Events\UserActivated;
use Nova\Users\Livewire\ActivateUserButton;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('users');
uses()->group('components');

beforeEach(function () {
    signIn(permissions: 'user.update');

    $this->user = User::factory()->inactive()->create();

    $this->character = Character::factory()
        ->hasAttached($this->user)
        ->inactive()
        ->create();
});

test('an inactive user can be activated with the button', function () {
    Event::fake();

    livewire(ActivateUserButton::class)
        ->set('user', $this->user)
        ->call('activate');

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
