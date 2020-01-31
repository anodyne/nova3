<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\ForcePasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForcePasswordResetTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        $this->action = app(ForcePasswordReset::class);
    }

    /** @test **/
    public function itSetsTheForcePasswordResetFlagToTrue()
    {
        $user = $this->action->execute($this->user);

        $this->assertInstanceOf(User::class, $user);

        $this->assertTrue($user->force_password_reset);
    }
}
