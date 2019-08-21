<?php

namespace Tests\Unit\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    /**
     * @test
     */
    public function itCanFlagUserToResetTheirPassword()
    {
        $this->user->forcePasswordReset();

        $this->assertTrue($this->user->fresh()->force_password_reset);
    }

    /**
     * @test
     */
    public function itRecordsTimestampWhenUserLogsIn()
    {
        $this->user->recordLoginTime();

        $this->assertNotNull($this->user->fresh()->last_login);
    }
}
