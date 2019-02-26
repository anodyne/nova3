<?php

namespace Tests\Unit\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    public function testItCanFlagAUserToResetTheirPassword()
    {
        $this->user->forcePasswordReset();

        $this->assertTrue($this->user->fresh()->force_password_reset);
    }

    public function testItRecordsATimestampWhenAUserLogsIn()
    {
        $this->user->recordLoginTime();

        $this->assertNotNull($this->user->fresh()->last_login);
    }
}