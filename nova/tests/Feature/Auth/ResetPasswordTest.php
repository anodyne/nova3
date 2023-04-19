<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group auth
 */
class ResetPasswordTest extends TestCase
{
    /** @test **/
    public function unauthenticatedUserCanViewEmailResetPage()
    {
        $token = $this->getPasswordResetToken(
            User::factory()->active()->create()
        );

        $response = $this->get(route('password.reset', $token));
        $response->assertSuccessful();
        $response->assertViewHas('token', $token);
    }

    /** @test **/
    public function authenticatedUserCannotViewEmailResetPage()
    {
        $this->signIn();

        $token = $this->getPasswordResetToken(auth()->user());

        $response = $this->get(route('password.reset', $token));
        $response->assertRedirect(route('home'));
    }

    /** @test **/
    public function userCanResetTheirPasswordWithValidPasswordResetToken()
    {
        Event::fake();

        $token = $this->getPasswordResetToken(
            $user = User::factory()->active()->create()
        );

        $response = $this->post(route('password.update'), [
            'email' => $user->email,
            'token' => $token,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect(route('home'));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(PasswordReset::class);
    }

    /** @test **/
    public function userCannotResetTheirPasswordWithInvalidPasswordResetToken()
    {
        $user = User::factory()->active()->create();

        $token = 'invalid-token';

        $response = $this->post(route('password.update'), [
            'email' => $user->email,
            'token' => $token,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test **/
    public function userCannotResetTheirPasswordWithoutNewPassword()
    {
        $token = $this->getPasswordResetToken(
            $user = User::factory()->active()->create()
        );

        $response = $this->post(route('password.update'), [
            'email' => $user->email,
            'token' => $token,
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test **/
    public function userCannotResetTheirPasswordWithoutEmail()
    {
        $token = $this->getPasswordResetToken(
            $user = User::factory()->active()->create()
        );

        $response = $this->post(route('password.update'), [
            'email' => '',
            'token' => $token,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors('email');

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
