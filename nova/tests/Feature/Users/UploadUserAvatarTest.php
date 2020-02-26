<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Users\Http\Controllers\UserController
 */
class UploadUserAvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var  \Nova\Users\Models\User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        Storage::fake('media');
    }

    /** @test **/
    public function authorizedUserCanUploadUserAvatar()
    {
        $this->signInWithPermission('user.update');

        $response = $this->put(route('users.update', $this->user), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'gender' => $this->user->gender,
            'roles' => [],
            'avatar' => UploadedFile::fake()->image('image.png'),
        ]);

        $this->followRedirects($response)->assertOk();

        $this->user->refresh();

        $this->assertStringContainsString("/media/users/{$this->user->id}", $this->user->avatar_url);

        $this->assertDatabaseHas('media', [
            'model_type' => 'users',
            'model_id' => $this->user->id,
            'collection_name' => 'avatar',
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotUploadUserAvatar()
    {
        $this->signIn();

        $response = $this->putJson(route('users.update', $this->user), [
            'avatar' => UploadedFile::fake()->image('image.png'),
        ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('media', [
            'model_type' => 'users',
            'model_id' => $this->user->id,
            'collection_name' => 'avatar',
        ]);
    }

    /** @test **/
    public function guestCannotUploadUserAvatar()
    {
        $response = $this->putJson(route('users.update', $this->user), [
            'avatar' => UploadedFile::fake()->image('image.png'),
        ]);

        $response->assertUnauthorized();

        $this->assertDatabaseMissing('media', [
            'model_type' => 'users',
            'model_id' => $this->user->id,
            'collection_name' => 'avatar',
        ]);
    }

    /** @test **/
    public function userCannotUploadAvatarLargerThanMaxFilesizeLimit()
    {
        $this->signInWithPermission('user.update');

        $fakeImage = UploadedFile::fake()->image('image.png');
        $fakeImage->size(config('medialibrary.max_file_size') / 1024 + 1);

        $response = $this->putJson(route('users.update', $this->user), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'roles' => [],
            'avatar' => $fakeImage,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('avatar');

        $this->assertDatabaseMissing('media', [
            'model_type' => 'users',
            'model_id' => $this->user->id,
            'collection_name' => 'avatar',
        ]);
    }

    /** @test **/
    public function userCanOnlyHaveOneAvatar()
    {
        $this->signInWithPermission('user.update');

        $this->putJson(route('users.update', $this->user), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'gender' => $this->user->gender,
            'roles' => [],
            'avatar' => UploadedFile::fake()->image('image.png'),
        ]);

        $response = $this->putJson(route('users.update', $this->user), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'gender' => $this->user->gender,
            'roles' => [],
            'avatar' => UploadedFile::fake()->image('image2.png'),
        ]);

        $this->followRedirects($response)->assertOk();

        $this->assertCount(1, $this->user->refresh()->getMedia('avatar'));
    }

    /** @test **/
    public function userCannotUploadInvalidFileForAvatar()
    {
        $this->signInWithPermission('user.update');

        $response = $this->putJson(route('users.update', $this->user), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'roles' => [],
            'avatar' => UploadedFile::fake()->create('random.tmp'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('avatar');

        $this->assertDatabaseMissing('media', [
            'model_type' => 'users',
            'model_id' => $this->user->id,
            'collection_name' => 'avatar',
        ]);
    }
}
