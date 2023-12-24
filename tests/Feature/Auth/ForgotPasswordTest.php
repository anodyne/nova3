<?php

declare(strict_types=1);

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function PHPUnit\Framework\assertNotNull;

uses()->group('auth');

test('user can view the forgot password page', function () {
    get(route('password.request'))->assertSuccessful();
});

test('user receives an email with a password reset link', function () {
    Notification::fake();

    $user = createUser();

    post(route('password.email'), [
        'email' => $user->email,
    ]);

    assertNotNull($token = DB::table('password_reset_tokens')->first());

    Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
        return Hash::check($notification->token, $token->token) === true;
    });
});

test('user does not receive an email with a password reset link if they are not registered', function () {
    Notification::fake();

    from(route('password.email'))
        ->post(route('password.email'), [
            'email' => 'nobody@example.com',
        ])
        ->assertRedirectToRoute('password.email')
        ->assertSessionHasErrors('email');

    Notification::assertNotSentTo(makeUser(['email' => 'nobody@example.com']), ResetPassword::class);
});

test('email is required', function () {
    from(route('password.email'))
        ->post(route('password.email'), [])
        ->assertRedirectToRoute('password.email')
        ->assertSessionHasErrors('email');
});

test('email is a valid email address', function () {
    from(route('password.email'))
        ->post(route('password.email'), [
            'email' => 'invalid-email',
        ])
        ->assertRedirectToRoute('password.email')
        ->assertSessionHasErrors('email');
});
