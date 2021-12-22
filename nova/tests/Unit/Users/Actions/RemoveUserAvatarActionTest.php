<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Actions\RemoveUserAvatar;
use Nova\Users\Actions\UploadUserAvatar;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 * @group uploads
 * @group media
 */
class RemoveUserAvatarActionTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->user = User::factory()->active()->create();

        UploadUserAvatar::run(
            $this->user,
            UploadedFile::fake()->image('image.png')
        );
    }

    /** @test **/
    public function itRemovesTheUserAvatar()
    {
        $this->assertCount(1, $this->user->getMedia('avatar'));

        RemoveUserAvatar::run($this->user, true);

        $this->assertCount(0, $this->user->refresh()->getMedia('avatar'));
    }

    /** @test **/
    public function itDoesNotRemoveTheUserAvatarWithAFalseValue()
    {
        $this->assertCount(1, $this->user->getMedia('avatar'));

        RemoveUserAvatar::run($this->user, false);

        $this->assertCount(1, $this->user->refresh()->getMedia('avatar'));
    }

    /** @test **/
    public function itDoesNotRemoveTheUserAvatarWithANullValue()
    {
        $this->assertCount(1, $this->user->getMedia('avatar'));

        RemoveUserAvatar::run($this->user);

        $this->assertCount(1, $this->user->refresh()->getMedia('avatar'));
    }
}
