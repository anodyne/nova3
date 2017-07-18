<?php namespace Tests\Users;

use Mail;
use Nova\Users\User;
use Tests\DatabaseTestCase;
use Nova\Users\Mail\SendAdminForcedPasswordResetNotification;

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
		Mail::fake();

		$admin = $this->createAdmin();

		$this->signIn($admin);

		create('Nova\Users\User', [], 3);

		$this->patch(route('users.reset-passwords'), ['users' => [2, 4]]);

		$users = User::whereIn('id', [2, 4])->get();

		$recipients = $users->map(function ($user) {
			return $user->email;
		})->all();

		Mail::assertSent(SendAdminForcedPasswordResetNotification::class, function ($mail) use ($recipients) {
			return $mail->hasBcc($recipients);
		});
	}

	/** @test **/
	public function has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);
		
		$this->get(route('users.force-password-reset'))->assertSuccessful();
	}
}
