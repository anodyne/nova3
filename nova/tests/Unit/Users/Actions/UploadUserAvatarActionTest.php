<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Actions\UploadUserAvatar;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 * @group uploads
 * @group media
 */
class UploadUserAvatarActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UploadUserAvatar::class);

        $this->user = User::factory()->active()->create();
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
