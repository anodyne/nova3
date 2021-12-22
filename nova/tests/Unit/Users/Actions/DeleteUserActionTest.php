<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Nova\Users\Actions\DeleteUser;
use Nova\Users\Exceptions\UserException;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 */
class DeleteUserActionTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itDeletesAUser()
    {
        $user = DeleteUser::run($this->user);

        $this->assertNotNull($user->deleted_at);
    }

    /** @test **/
    public function itThrowsAnExceptionIfTheCurrentUserTriesToDeleteTheirAccount()
    {
        $this->expectException(UserException::class);

        $this->signIn($this->user);

        DeleteUser::run($this->user);
    }
}
