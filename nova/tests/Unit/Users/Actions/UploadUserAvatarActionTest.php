<?php

declare(strict_types=1);
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Actions\UploadUserAvatar;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
it('stores the user avatar', function () {
    $disk = Storage::fake('media');

    $diskPathPrefix = $disk->getAdapter()->getPathPrefix();

    expect($this->user->getMedia('avatar'))->toHaveCount(0);

    config()->set('filesystems.disks.media', [
        'driver' => 'local',
        'root' => $diskPathPrefix,
    ]);

    $path = $disk->put('tmp', UploadedFile::fake()->image('image.png'));

    UploadUserAvatar::run($this->user, $diskPathPrefix.$path);

    expect($this->user->refresh()->getMedia('avatar'))->toHaveCount(1);
});
