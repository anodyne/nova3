<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 */
class ForcePasswordResetActionTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itSetsTheForcePasswordResetFlagToTrue()
    {
        $user = ForcePasswordReset::run($this->user);

        $this->assertTrue($user->force_password_reset);
    }
}
