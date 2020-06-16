<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewEmailResetPage()
    {
        $token = $this->getPasswordResetToken(create(User::class));

        $response = $this->get(route('password.reset', $token))
            ->assertSuccessful()
            ->assertViewHas('token', $token);
    }

    public function testAuthenticatedUserCannotViewEmailResetPage()
    {
        $this->signIn();

        $token = $this->getPasswordResetToken(auth()->user());

        $response = $this->get(route('password.reset', $token))
            ->assertRedirect(route('home'));
    }

    public function testGuestCanResetTheirPasswordWithValidPasswordResetToken()
    {
        Event::fake();

        $user = create(User::class);

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

    public function testGuestCannotResetTheirPasswordWithInvalidPasswordResetToken()
    {
        $user = create(User::class);

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

    public function testGuestCannotResetTheirPasswordWithoutNewPassword()
    {
        $user = create(User::class);

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

    public function testGuestCannotResetTheirPasswordWithoutEmail()
    {
        $user = create(User::class);

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
