<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nova\Users\Livewire\MyAccountInfo;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses()->group('account');

beforeEach(function () {
    signIn();

    $this->user = Auth::user();
});

test('a user can view their account info', function () {
    get(route('account.edit'))
        ->assertSuccessful()
        ->assertSeeLivewire(MyAccountInfo::class);

    livewire(MyAccountInfo::class)
        ->assertSet('form.name', $this->user->name)
        ->assertSet('form.email', $this->user->email)
        ->assertSet('form.pronouns', $this->user->pronouns->value)
        ->assertSet('form.pronounSubject', $this->user->pronouns->subject)
        ->assertSet('form.pronounObject', $this->user->pronouns->object)
        ->assertSet('form.pronounPossessive', $this->user->pronouns->possessive)
        ->assertSet('form.currentPassword', '')
        ->assertSet('form.newPassword', '')
        ->assertSet('form.newPasswordConfirmation', '');
});

test('a user can update their account info without updating their password', function () {
    assertDatabaseHas(User::class, [
        'name' => $this->user->name,
        'email' => $this->user->email,
        'pronouns->value' => 'none',
        'pronouns->subject' => null,
        'pronouns->object' => null,
        'pronouns->possessive' => null,
    ]);

    livewire(MyAccountInfo::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'johndoe@example.com')
        ->set('form.pronouns', 'male')
        ->call('save')
        ->assertNotified()
        ->assertHasNoErrors();

    assertDatabaseHas(User::class, [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'pronouns->value' => 'male',
        'pronouns->subject' => 'he',
        'pronouns->object' => 'him',
        'pronouns->possessive' => 'his',
    ]);
});

test('a user can update their password', function () {
    assertTrue(Hash::check('secret', $this->user->password));

    livewire(MyAccountInfo::class)
        ->set('form.currentPassword', 'secret')
        ->set('form.newPassword', 'password')
        ->set('form.newPasswordConfirmation', 'password')
        ->call('save')
        ->assertNotified()
        ->assertHasNoErrors();

    assertFalse(Hash::check('secret', $this->user->password));
    assertTrue(Hash::check('password', $this->user->password));
});
