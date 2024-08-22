<?php

declare(strict_types=1);

use Nova\Users\Livewire\UserNotificationPreferencesList;

use function Pest\Laravel\get;

uses()->group('account');

test('a user can view their notification preferences', function () {
    signIn();

    get(route('admin.account.notifications'))
        ->assertSuccessful()
        ->assertSeeLivewire(UserNotificationPreferencesList::class);
});
