<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

class ForgotPasswordTest extends TestCase
{
    /** @test **/
    public function a_user_can_view_the_email_password_page()
    {
        $this->get(route('password.request'))
            ->assertSuccessful();
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_email_password_page()
    {
        $this->signIn();

        $this->get(route('password.request'))
            ->assertRedirect(route('home'));
    }

    /** @test **/
    public function a_user_receives_an_email_with_a_password_reset_link()
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

    /** @test **/
    public function an_unregistered_user_does_not_receive_an_email_with_a_password_reset_link()
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

    /** @test **/
    public function email_is_required_on_email_password_page()
    {
        $this->from(route('password.request'))
            ->post(route('password.email'), [])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');
    }

    /** @test **/
    public function valid_email_is_required_on_email_password_page()
    {
        $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'invalid-email'
            ])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');
    }
}
