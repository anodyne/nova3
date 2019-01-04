<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Nova\Users\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_can_view_the_email_reset_page()
    {
        $token = $this->getPasswordResetToken($this->createUser());

        $response = $this->get(route('password.reset', $token))
            ->assertSuccessful()
            ->assertResponseHas('token', $token);
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_email_reset_page()
    {
        $user = $this->signIn();

        $token = $this->getPasswordResetToken($user);

        $response = $this->get(route('password.reset', $token))
            ->assertRedirect(route('home'));
    }

    /** @test **/
    public function a_user_can_reset_their_password_with_a_valid_password_reset_token()
    {
        Event::fake();

        $user = $this->createUser();

        $token = $this->getPasswordResetToken($user);

        $this->from(route('password.reset', $token))
            ->post(route('password.update'), [
                'email' => $user->email,
                'token' => $token,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect(route('home'));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(PasswordReset::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }

    /** @test **/
    public function a_user_cannot_reset_their_password_with_an_invalid_password_reset_token()
    {
        $user = $this->createUser();

        $token = 'invalid-token';

        $this->from(route('password.reset', $token))
            ->post(route('password.update'), [
                'email' => $user->email,
                'token' => $token,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect(route('password.reset', $token));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test **/
    public function a_user_cannot_reset_their_password_without_providing_a_new_password()
    {
        $user = $this->createUser();

        $token = $this->getPasswordResetToken($user);

        $this->from(route('password.reset', $token))
            ->post(route('password.update'), [
                'email' => $user->email,
                'token' => $token,
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect(route('password.reset', $token))
            ->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test **/
    public function a_user_cannot_reset_their_password_without_providing_an_email()
    {
        $user = $this->createUser();

        $token = $this->getPasswordResetToken($user);

        $this->from(route('password.reset', $token))
            ->post(route('password.update'), [
                'email' => '',
                'token' => $token,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect(route('password.reset', $token))
            ->assertSessionHasErrors('email');

        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
        $this->assertGuest();
    }

    protected function getPasswordResetToken(User $user)
    {
        return Password::broker()->createToken($user);
    }
}
