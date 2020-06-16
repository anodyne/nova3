<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group auth
 */
class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function unauthenticatedUserCanViewEmailPasswordPage()
    {
        $response = $this->get(route('password.request'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function userIsSentEmailWithPasswordResetLink()
    {
        Notification::fake();

        $user = create(User::class);

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $this->assertNotNull(DB::table('password_resets')->first());

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /** @test **/
    public function authenticatedUserCannotViewEmailPasswordPage()
    {
        $this->signIn();

        $response = $this->get(route('password.request'));
        $response->assertRedirect(route('home'));
    }

    /** @test **/
    public function passwordResetEmailDoesNotGetSentToAnInvalidEmailAddress()
    {
        Notification::fake();

        $response = $this->post(route('password.email'), [
            'email' => 'nobody@example.com',
        ]);
        $response->assertSessionHasErrors('email');

        Notification::assertNotSentTo(make(User::class), ResetPassword::class);
    }

    /** @test **/
    public function emailIsRequiredToStartThePasswordResetProcess()
    {
        $response = $this->post(route('password.email'), []);
        $response->assertSessionHasErrors('email');
    }

    /** @test **/
    public function validEmailIsRequiredToStartThePasswordResetProcess()
    {
        $response = $this->post(route('password.email'), [
            'email' => 'invalid-email',
        ]);
        $response->assertSessionHasErrors('email');
    }
}
