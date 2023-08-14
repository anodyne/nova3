<?php

declare(strict_types=1);
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Models\User;
beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
it('sets the force password reset flag to true', function () {
    $user = ForcePasswordReset::run($this->user);

    expect($user->force_password_reset)->toBeTrue();
});
