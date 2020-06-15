<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewEmailPasswordPage()
    {
        $this->get(route('password.request'))
            ->assertSuccessful();
    }

    public function testAuthenticatedUserCannotViewEmailPasswordPage()
    {
        $this->signIn();

        $this->get(route('password.request'))
            ->assertRedirect(route('home'));
    }

    public function testUserIsSentEmailWithPasswordResetLink()
    {
        Notification::fake();

        $user = $this->createUser();

        $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => $user->email,
            ])
            ->assertRedirect(route('password.request'));

        $this->assertNotNull($token = DB::table('password_resets')->first());

        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }

    public function testGuestIsNotSentEmailWithPasswordResetLink()
    {
        Notification::fake();

        $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'nobody@example.com',
            ])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');

        Notification::assertNotSentTo($this->makeUser(), ResetPassword::class);
    }

    public function testEmailIsRequiredOnEmailPasswordPage()
    {
        $this->from(route('password.request'))
            ->post(route('password.email'), [])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');
    }

    public function testValidEmailIsRequiredOnEmailPasswordPage()
    {
        $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'invalid-email',
            ])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');
    }
}
