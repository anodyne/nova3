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

    /** @test **/
    public function it_can_flag_a_user_to_reset_their_password()
    {
        $this->user->forcePasswordReset();

        $this->assertTrue($this->user->fresh()->force_password_reset);
    }

    /** @test **/
    public function it_records_a_timestamp_when_a_user_logs_in()
    {
        $this->user->recordLoginTime();

        $this->assertNotNull($this->user->fresh()->last_login);
    }
}