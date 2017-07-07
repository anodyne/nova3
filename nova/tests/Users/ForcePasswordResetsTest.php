<?php namespace Tests\Users;

use Tests\DatabaseTestCase;

class ForcePasswordResetsTest extends DatabaseTestCase
{
	/** @test **/
	public function an_authorized_user_can_reset_passwords()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		create('Nova\Users\User', [], 3);

		$this->patch(route('users.reset-passwords'), ['users' => [2, 4]]);

		$this->assertDatabaseHas('users', ['id' => 2, 'password' => null]);
		$this->assertDatabaseHas('users', ['id' => 4, 'password' => null]);
	}

	/** @test **/
	public function an_email_is_sent_to_users_who_have_passwords_reset()
	{
		//
	}
}
