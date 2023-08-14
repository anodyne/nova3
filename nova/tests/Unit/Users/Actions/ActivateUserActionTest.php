<?php

declare(strict_types=1);
use Nova\Users\Actions\ActivateUser;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->inactive()->create();
});
it('activates a user', function () {
    $user = ActivateUser::run($this->user);

    expect($user->status)->toBeInstanceOf(Active::class);
});
