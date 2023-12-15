<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Users\Livewire\MyAccountPreferences;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('account');

beforeEach(function () {
    signIn();

    $this->user = Auth::user();
});

test('a user can view their account preferences', function () {
    get(route('account.edit', 'preferences'))
        ->assertSuccessful()
        ->assertSeeLivewire(MyAccountPreferences::class);

    livewire(MyAccountPreferences::class)
        ->assertSet('form.timezone', 'UTC');
});

test('a user can update their account preferences', function () {
    assertDatabaseHas(User::class, [
        'name' => $this->user->name,
        'email' => $this->user->email,
        'preferences->timezone' => 'UTC',
    ]);

    livewire(MyAccountPreferences::class)
        ->set('form.timezone', 'America/New_York')
        ->call('save')
        ->assertNotified()
        ->assertHasNoErrors();

    assertDatabaseHas(User::class, [
        'name' => $this->user->name,
        'email' => $this->user->email,
        'preferences->timezone' => 'America/New_York',
    ]);
});
