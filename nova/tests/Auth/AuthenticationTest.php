<?php namespace Tests\Auth;

use Tests\DatabaseTestCase;

class AuthenticationTest extends DatabaseTestCase
{
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = $this->createUser();
	}

	/** @test **/
	public function a_user_can_sign_in()
	{
		$this->post('/login', [
				'email' => $this->user->email,
				'password' => 'secret'
			])
			->assertRedirect('/');
	}

	/** @test **/
	public function a_user_can_sign_out()
	{
		$this->signIn();

		$this->assertNotEquals(null, auth()->user());

		$this->post(route('logout'));

		$this->assertEquals(null, auth()->user());
	}

	/** @test **/
	public function a_user_gets_locked_out_after_five_wrong_sign_in_attempts()
	{
		for ($a = 1; $a <= 6; $a++) {
			$response = $this->json('POST', '/login', [
				'email' => $this->user->email,
				'password' => 'foo'
			]);
		}

		$response->assertStatus(423);
	}

	/** @test **/
	public function sign_in_requires_a_valid_email_address()
	{
		$this->withExceptionHandling();

		$this->post('/login', ['email' => '', 'password' => 'password'])
			->assertSessionHasErrors('email');

		$this->post('/login', ['email' => 'foo', 'password' => 'password'])
			->assertSessionHasErrors('email');

		$this->post('/login', ['email' => new \stdClass, 'password' => 'password'])
			->assertSessionHasErrors('email');
	}

	/** @test **/
	public function sign_in_requires_a_password()
	{
		$this->withExceptionHandling();

		$this->post('/login', ['email' => 'foo@example.com', 'password' => ''])
			->assertSessionHasErrors('password');

		$this->post('/login', ['email' => 'foo@example.com', 'password' => new \stdClass])
			->assertSessionHasErrors('password');
	}

	/** @test **/
	public function only_users_in_the_database_can_sign_in()
	{
		# code...
	}
}
