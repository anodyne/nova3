<?php namespace Tests\Feature;

use Tests\DatabaseTestCase;

class UserAuthenticationTest extends DatabaseTestCase
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
	public function a_user_must_use_valid_credentials()
	{
		$this->postWithRedirect('/login', [
				'email' => $this->user->email,
				'password' => 'foo'
			], '/login')
			->assertRedirect('/login');
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
}
