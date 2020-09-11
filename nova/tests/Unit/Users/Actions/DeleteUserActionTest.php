<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Exceptions\CannotDeleteOwnAccountException;

/**
 * @group users
 */
class DeleteUserActionTest extends TestCase
{
    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteUser::class);

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itDeletesAUser()
    {
        $user = $this->action->execute($this->user);

        $this->assertNotNull($user->deleted_at);
    }

    /** @test **/
    public function itThrowsAnExceptionIfTheCurrentUserTriesToDeleteTheirAccount()
    {
        $this->expectException(CannotDeleteOwnAccountException::class);

        $this->signIn($this->user);

        $this->action->execute($this->user);
    }
}
