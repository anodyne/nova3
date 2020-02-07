<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Actions\RemoveUserAvatar;
use Nova\Users\Actions\UploadUserAvatar;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemoveUserAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        Storage::fake('media');

        app(UploadUserAvatar::class)->execute(
            $this->user,
            UploadedFile::fake()->image('image.png')
        );

        $this->action = app(RemoveUserAvatar::class);
    }

    /** @test **/
    public function itRemovesTheUserAvatar()
    {
        $user = $this->action->execute($this->user, true);

        $this->assertInstanceOf(User::class, $user);

        $this->assertCount(0, $user->getMedia('avatar'));
    }

    /** @test **/
    public function itDoesNotRemoveTheUserAvatarWithAFalseValue()
    {
        $user = $this->action->execute($this->user, false);

        $this->assertInstanceOf(User::class, $user);

        $this->assertCount(1, $user->getMedia('avatar'));
    }

    /** @test **/
    public function itDoesNotRemoveTheUserAvatarWithANullValue()
    {
        $user = $this->action->execute($this->user);

        $this->assertInstanceOf(User::class, $user);

        $this->assertCount(1, $user->getMedia('avatar'));
    }
}
