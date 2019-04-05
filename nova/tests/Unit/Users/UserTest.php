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

    public function testItCanFlagUserToResetTheirPassword()
    {
        $this->user->forcePasswordReset();

        $this->assertTrue($this->user->fresh()->force_password_reset);
    }

    public function testItRecordsTimestampWhenUserLogsIn()
    {
        $this->user->recordLoginTime();

        $this->assertNotNull($this->user->fresh()->last_login);
    }
}
