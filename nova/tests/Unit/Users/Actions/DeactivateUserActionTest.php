<?php

declare(strict_types=1);
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
it('deactivates a user', function () {
    $user = DeactivateUser::run($this->user);

    expect($user->status)->toBeInstanceOf(Inactive::class);
});
