<?php

namespace Tests\Feature\Authenticate;

use Mail;
use Tests\DatabaseTestCase;
use Nova\Auth\Mail\SendPasswordReset;

# TODO: how would we catch an issue where the view doesn't exist?

class PasswordResetTest extends DatabaseTestCase
{
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = $this->createUser();
	}

	/** @test **/
	public function password_reset_request_requires_a_valid_email_address()
	{
		$this->post(route('password.email'), ['email' => ''])
			->assertSessionHasErrors('email');

		$this->post(route('password.email'), ['email' => 'foo'])
			->assertSessionHasErrors('email');

		$this->post(route('password.email'), ['email' => 'foo@example.com'])
			->assertSessionHasErrors('email');
	}

	/** @test **/
	public function the_password_reset_token_is_emailed_to_the_requesting_user()
	{
		Mail::fake();

		$user = $this->user;

		$this->post(route('password.email'), ['email' => $user->email]);

		Mail::assertSent(SendPasswordReset::class, function ($mail) use ($user) {
			return $mail->hasTo($user->email);
		});
	}

	/** @test **/
	public function password_reset_requires_a_valid_email_address()
	{
		$this->post('/password/reset', ['email' => ''])
			->assertSessionHasErrors('email');
	}

	/** @test **/
	public function password_reset_requires_a_valid_password()
	{
		$this->withExceptionHandling();

		$this->post('/password/reset', ['password' => ''])
			->assertSessionHasErrors('password');

		$this->post('/password/reset', ['password' => 'foo'])
			->assertSessionHasErrors('password');

		$this->post('/password/reset', ['password' => 'foo123', 'password_confirmation' => 'foo987'])
			->assertSessionHasErrors('password');
	}

	/** @test **/
	public function password_reset_requires_a_valid_token()
	{
		$this->post('/password/reset', ['token' => ''])
			->assertSessionHasErrors('token');

		$this->post('/password/reset', ['token' => \Str::random(40)])
			->assertSessionHasErrors('email');
	}

	/** @test **/
	public function has_no_errors()
	{
		$this->get(route('password.request'))->assertSuccessful();
		$this->get(route('password.reset', 'abc123'))->assertSuccessful();
	}
}
