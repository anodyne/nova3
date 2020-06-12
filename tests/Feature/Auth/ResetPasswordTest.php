<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

uses()->group('feature', 'auth');

beforeEach(function () {
    $this->user = $this->createUser();
    $this->token = Password::broker()->createToken($this->user);
});

test('guest can view the reset password page', function () {
    $response = $this->get(route('password.reset', $this->token));

    $response->assertSuccessful();
    $response->assertViewHas('token', $this->token);
});

test('authenticated user cannot view the reset password page', function () {
    $this->signIn($this->user);

    $response = $this->get(route('password.reset', $this->token));
    $response->assertRedirect(route('home'));
});

test('user can reset their password with a valid reset token', function () {
    Event::fake();

    $this->from(route('password.reset', $this->token))
        ->post(route('password.update'), [
            'email' => $this->user->email,
            'token' => $this->token,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('home'));

    $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
    $this->assertAuthenticatedAs($this->user);

    Event::assertDispatched(PasswordReset::class, function ($event) {
        return $event->user->is($this->user);
    });
});

test('user cannot reset their password with an invalid reset token', function () {
    $token = 'invalid-token';

    $this->from(route('password.reset', $token))
        ->post(route('password.update'), [
            'email' => $this->user->email,
            'token' => $token,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('password.reset', $token));

    $this->assertTrue(Hash::check('secret', $this->user->fresh()->password));
    $this->assertGuest();
});

test('user cannot reset their password without a new password', function () {
    $this->from(route('password.reset', $this->token))
        ->post(route('password.update'), [
            'email' => $this->user->email,
            'token' => $this->token,
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirect(route('password.reset', $this->token))
        ->assertSessionHasErrors('password');

    $this->assertTrue(session()->hasOldInput('email'));
    $this->assertFalse(session()->hasOldInput('password'));
    $this->assertTrue(Hash::check('secret', $this->user->fresh()->password));
    $this->assertGuest();
});

test('user cannot reset their password without their email address', function () {
    $this->from(route('password.reset', $this->token))
        ->post(route('password.update'), [
            'email' => '',
            'token' => $this->token,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('password.reset', $this->token))
        ->assertSessionHasErrors('email');

    $this->assertFalse(session()->hasOldInput('password'));
    $this->assertTrue(Hash::check('secret', $this->user->fresh()->password));
    $this->assertGuest();
});
