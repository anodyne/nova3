<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Nova\Users\Livewire\DeleteMyAccount;
use Nova\Users\Models\User;
use Nova\Users\Notifications\UserDeletedAccount;

use function Pest\Laravel\assertGuest;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('account');

beforeEach(function () {
    signIn();

    $this->user = Auth::user();
});

test('a user can view the delete account page', function () {
    get(route('account.edit', 'delete'))
        ->assertSuccessful()
        ->assertSeeLivewire(DeleteMyAccount::class);
});

test('a user can delete their account', function () {
    Notification::fake();

    $admin = createUser(attributes: ['email' => 'admin@example.com'], permissions: 'user.update');

    livewire(DeleteMyAccount::class)->call('delete');

    assertSoftDeleted(User::class, [
        'id' => $this->user->id,
    ]);

    Notification::assertSentTo($admin, UserDeletedAccount::class);

    assertGuest();
});
