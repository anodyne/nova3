<?php

declare(strict_types=1);
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Actions\RemoveUserAvatar;
use Nova\Users\Actions\UploadUserAvatar;
use Nova\Users\Models\User;
beforeEach(function () {
    Storage::fake('media');

    $this->user = User::factory()->active()->create();

    UploadUserAvatar::run(
        $this->user,
        UploadedFile::fake()->image('image.png')
    );
});
it('removes the user avatar', function () {
    expect($this->user->getMedia('avatar'))->toHaveCount(1);

    RemoveUserAvatar::run($this->user, true);

    expect($this->user->refresh()->getMedia('avatar'))->toHaveCount(0);
});
it('does not remove the user avatar with a false value', function () {
    expect($this->user->getMedia('avatar'))->toHaveCount(1);

    RemoveUserAvatar::run($this->user, false);

    expect($this->user->refresh()->getMedia('avatar'))->toHaveCount(1);
});
it('does not remove the user avatar with a null value', function () {
    expect($this->user->getMedia('avatar'))->toHaveCount(1);

    RemoveUserAvatar::run($this->user);

    expect($this->user->refresh()->getMedia('avatar'))->toHaveCount(1);
});
