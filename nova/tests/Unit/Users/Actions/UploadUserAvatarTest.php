<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Actions\UploadUserAvatar;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadUserAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        $this->action = app(UploadUserAvatar::class);
    }

    /** @test **/
    public function itStoresTheUserAvatar()
    {
        Storage::fake('media');

        $user = $this->action->execute(
            $this->user,
            UploadedFile::fake()->image('image.png')
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertCount(1, $user->getMedia('avatar'));
    }
}
