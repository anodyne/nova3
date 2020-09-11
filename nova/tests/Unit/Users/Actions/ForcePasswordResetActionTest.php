<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\ForcePasswordReset;

/**
 * @group users
 */
class ForcePasswordResetActionTest extends TestCase
{
    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(ForcePasswordReset::class);

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itSetsTheForcePasswordResetFlagToTrue()
    {
        $user = $this->action->execute($this->user);

        $this->assertTrue($user->force_password_reset);
    }
}
