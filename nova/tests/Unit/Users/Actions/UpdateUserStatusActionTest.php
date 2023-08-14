<?php

declare(strict_types=1);
use Nova\Users\Actions\UpdateUserStatus;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\User;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
it('can transition from pending to active', function () {
    $user = User::factory()->create();

    UpdateUserStatus::run($user, Active::class);

    expect($user->status)->toBeInstanceOf(Active::class);
});
it('can transition from pending to inactive', function () {
    $user = User::factory()->create();

    UpdateUserStatus::run($user, Inactive::class);

    expect($user->status)->toBeInstanceOf(Inactive::class);
});
it('can transition from active to inactive', function () {
    UpdateUserStatus::run($this->user, Inactive::class);

    expect($this->user->status)->toBeInstanceOf(Inactive::class);
});
it('can transition from inactive to active', function () {
    $user = User::factory()->inactive()->create();

    UpdateUserStatus::run($user, Active::class);

    expect($user->status)->toBeInstanceOf(Active::class);
});
it('throws an exception if the user cannot be transitioned to the status', function () {
    $this->expectException(TransitionNotFound::class);

    UpdateUserStatus::run($this->user, Pending::class);

    $this->assertNotEquals(Pending::class, $this->user->status);
});
