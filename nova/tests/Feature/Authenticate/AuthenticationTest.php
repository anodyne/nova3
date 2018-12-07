<?php

namespace Tests\Feature\Authenticate;

use Tests\DatabaseTestCase;
use Tests\ManagesTestUsers;
use Illuminate\Http\Response;

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
		$this->post('/sign-in', [
				'email' => $this->user->email,
				'password' => 'secret'
			])
			->assertRedirect(route('dashboard'));
	}

	/** @test **/
	public function a_user_can_sign_out()
	{
		$this->signIn();

		$this->assertNotEquals(null, auth()->user());

		$this->post(route('sign-out'));

		$this->assertEquals(null, auth()->user());
	}

	/** @test **/
	public function a_user_gets_locked_out_after_five_wrong_sign_in_attempts()
	{
		for ($a = 1; $a <= 6; $a++) {
			$response = $this->postJson('/sign-in', [
				'email' => $this->user->email,
				'password' => 'foo'
			]);
		}

		$response->assertStatus(Response::HTTP_LOCKED);
	}

	/** @test **/
	public function sign_in_requires_a_valid_email_address()
	{
		$this->post('/sign-in', ['email' => '', 'password' => 'password'])
			->assertSessionHasErrors('email');

		$this->post('/sign-in', ['email' => 'foo', 'password' => 'password'])
			->assertSessionHasErrors('email');

		$this->post('/sign-in', ['email' => new \stdClass, 'password' => 'password'])
			->assertSessionHasErrors('email');
	}

	/** @test **/
	public function sign_in_requires_a_password()
	{
		$this->post('/sign-in', ['email' => 'foo@example.com', 'password' => ''])
			->assertSessionHasErrors('password');

		$this->post('/sign-in', ['email' => 'foo@example.com', 'password' => new \stdClass])
			->assertSessionHasErrors('password');
	}

	/** @test **/
	public function a_user_can_be_forced_to_reset_their_password()
	{
		$user = $this->createUser();
		$user->update(['password' => null]);

		$this->post('/sign-in', [
				'email' => $user->email,
				'password' => 'secret'
			])
			->assertRedirect(route('password.request'));
	}

	/** @test **/
	public function a_timestamp_is_recorded_when_a_user_signs_in()
	{
		$user = $this->createUser();

		$this->assertEquals(null, $user->last_sign_in);

		$this->post('/sign-in', [
			'email' => $user->email,
			'password' => 'secret'
		]);

		$this->assertNotEquals(null, $user->fresh()->last_sign_in);
	}

	/** @test **/
	public function has_no_errors()
	{
		$this->get(route('login'))->assertSuccessful();
	}
}
