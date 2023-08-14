<?php

declare(strict_types=1);
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Nova\Users\Models\User;
test('unauthenticated user can view email reset page', function () {
    $token = getPasswordResetToken(User::factory()->active()->create());

    $response = $this->get(route('password.reset', $token));
    $response->assertSuccessful();
    $response->assertViewHas('token', $token);
});
test('authenticated user cannot view email reset page', function () {
    $this->signIn();

    $token = getPasswordResetToken(auth()->user());

    $response = $this->get(route('password.reset', $token));
    $response->assertRedirect(route('home'));
});
test('user can reset their password with valid password reset token', function () {
    Event::fake();

    $token = getPasswordResetToken($user = User::factory()->active()->create());

    $response = $this->post(route('password.update'), [
        'email' => $user->email,
        'token' => $token,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertRedirect(route('home'));

    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
    $this->assertAuthenticatedAs($user);

    Event::assertDispatched(PasswordReset::class);
});
test('user cannot reset their password with invalid password reset token', function () {
    $user = User::factory()->active()->create();

    $token = 'invalid-token';

    $response = $this->post(route('password.update'), [
        'email' => $user->email,
        'token' => $token,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('secret', $user->fresh()->password))->toBeTrue();
    $this->assertGuest();
});
test('user cannot reset their password without new password', function () {
    $token = getPasswordResetToken($user = User::factory()->active()->create());

    $response = $this->post(route('password.update'), [
        'email' => $user->email,
        'token' => $token,
        'password' => '',
        'password_confirmation' => '',
    ]);
    $response->assertSessionHasErrors('password');

    expect(session()->hasOldInput('email'))->toBeTrue();
    expect(session()->hasOldInput('password'))->toBeFalse();
    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('secret', $user->fresh()->password))->toBeTrue();
    $this->assertGuest();
});
test('user cannot reset their password without email', function () {
    $token = getPasswordResetToken($user = User::factory()->active()->create());

    $response = $this->post(route('password.update'), [
        'email' => '',
        'token' => $token,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertSessionHasErrors('email');

    expect(session()->hasOldInput('password'))->toBeFalse();
    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('secret', $user->fresh()->password))->toBeTrue();
    $this->assertGuest();
});
function getPasswordResetToken(User $user)
{
    return Password::broker()->createToken($user);
}
