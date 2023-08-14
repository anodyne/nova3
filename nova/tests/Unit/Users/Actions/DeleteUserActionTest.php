<?php

declare(strict_types=1);
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Exceptions\UserException;
use Nova\Users\Models\User;
beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
it('deletes a user', function () {
    $user = DeleteUser::run($this->user);

    expect($user->deleted_at)->not->toBeNull();
});
it('throws an exception if the current user tries to delete their account', function () {
    $this->expectException(UserException::class);

    $this->signIn($this->user);

    DeleteUser::run($this->user);
});
