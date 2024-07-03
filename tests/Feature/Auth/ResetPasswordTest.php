<?php

declare(strict_types=1);

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use function Pest\Laravel\assertGuest;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses()->group('auth');

function getValidToken($user)
{
    return Password::broker()->createToken($user);
}

test('user can view the password reset page', function () {
    $user = createUser();

    get(route('password.reset', getValidToken($user)))
        ->assertSuccessful();
});

test('user can reset password with a valid token', function () {
    Event::fake();

    $user = createUser();

    post(route('password.update'), [
        'token' => getValidToken($user),
        'email' => $user->email,
        'password' => 'new-awesome-password',
        'password_confirmation' => 'new-awesome-password',
    ])
        ->assertRedirectToRoute('login');

    assertEquals($user->email, $user->fresh()->email);
    assertTrue(Hash::check('new-awesome-password', $user->fresh()->password));

    Event::assertDispatched(PasswordReset::class, function ($e) use ($user) {
        return $e->user->id === $user->id;
    });
});

test('user cannot reset password with an invalid token', function () {
    $user = createUser(attributes: [
        'password' => 'old-password',
    ]);

    from(route('password.reset', 'invalid-token'))
        ->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ])
        ->assertRedirectToRoute('password.reset', 'invalid-token');

    assertEquals($user->email, $user->fresh()->email);
    assertTrue(Hash::check('old-password', $user->fresh()->password));

    assertGuest();
});

test('user cannot reset password without providing a new password', function () {
    $user = createUser(attributes: [
        'password' => 'old-password',
    ]);

    from(route('password.reset', $token = getValidToken($user)))
        ->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirectToRoute('password.reset', $token)
        ->assertSessionHasErrors('password');

    assertTrue(session()->hasOldInput('email'));
    assertFalse(session()->hasOldInput('password'));
    assertEquals($user->email, $user->fresh()->email);
    assertTrue(Hash::check('old-password', $user->fresh()->password));

    assertGuest();
});

test('user cannot reset password without providing an email', function () {
    $user = createUser(attributes: [
        'password' => 'old-password',
    ]);

    from(route('password.reset', $token = getValidToken($user)))
        ->post(route('password.update'), [
            'token' => $token,
            'email' => '',
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ])
        ->assertRedirectToRoute('password.reset', $token)
        ->assertSessionHasErrors('email');

    assertFalse(session()->hasOldInput('password'));
    assertEquals($user->email, $user->fresh()->email);
    assertTrue(Hash::check('old-password', $user->fresh()->password));

    assertGuest();
});
