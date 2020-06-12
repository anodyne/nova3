<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

uses()->group('feature', 'auth');

test('guest can view the email password page')
    ->get('/password/reset')
    ->assertSuccessful();

test('authenticated user cannot view the email password page')
    ->signIn()
    ->get('/password/reset')
    ->assertRedirect('/');

test('UserIsSentEmailWithPasswordResetLink', function () {
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
});

test('guest is not sent email with password reset link', function () {
    Notification::fake();

    $this->from(route('password.request'))
        ->post(route('password.email'), [
            'email' => 'nobody@example.com',
        ])
        ->assertRedirect(route('password.request'))
        ->assertSessionHasErrors('email');

    Notification::assertNotSentTo($this->makeUser(), ResetPassword::class);
});

test('email is required to email password reset link')
    ->from('/password/reset')
    ->post('/password/email', [])
    ->assertRedirect('/password/reset')
    ->assertSessionHasErrors('email');

test('valid email address is required to email password reset link')
    ->from('/password/reset')
    ->post('/password/email', ['email' => 'invalid-email'])
    ->assertRedirect('/password/reset')
    ->assertSessionHasErrors('email');
