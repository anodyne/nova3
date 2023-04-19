<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group auth
 */
class ForgotPasswordTest extends TestCase
{
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

        $user = User::factory()->active()->create();

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

        Notification::assertNotSentTo(
            User::factory()->make(),
            ResetPassword::class
        );
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
