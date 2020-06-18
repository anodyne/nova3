<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Actions\UploadUserAvatar;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadUserAvatarActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UploadUserAvatar::class);

        $this->user = create(User::class, [], ['status:active']);
    }

    /** @test **/
    public function itStoresTheUserAvatar()
    {
        $disk = Storage::fake('media');

        $diskPathPrefix = $disk->getAdapter()->getPathPrefix();

        $this->assertCount(0, $this->user->getMedia('avatar'));

        config()->set('filesystems.disks.media', [
            'driver' => 'local',
            'root' => $diskPathPrefix,
        ]);

        $path = $disk->put('tmp', UploadedFile::fake()->image('image.png'));

        $this->action->execute($this->user, $diskPathPrefix . $path);

        $this->assertCount(1, $this->user->refresh()->getMedia('avatar'));
    }
}
