<?php

declare(strict_types=1);
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Nova\Users\Models\User;
test('unauthenticated user can view email password page', function () {
    $response = $this->get(route('password.request'));
    $response->assertSuccessful();
});
test('user is sent email with password reset link', function () {
    Notification::fake();

    $user = User::factory()->active()->create();

    $response = $this->post(route('password.email'), [
        'email' => $user->email,
    ]);

    expect(DB::table('password_resets')->first())->not->toBeNull();

    Notification::assertSentTo($user, ResetPassword::class);
});
test('authenticated user cannot view email password page', function () {
    $this->signIn();

    $response = $this->get(route('password.request'));
    $response->assertRedirect(route('home'));
});
test('password reset email does not get sent to an invalid email address', function () {
    Notification::fake();

    $response = $this->post(route('password.email'), [
        'email' => 'nobody@example.com',
    ]);
    $response->assertSessionHasErrors('email');

    Notification::assertNotSentTo(
        User::factory()->make(),
        ResetPassword::class
    );
});
test('email is required to start the password reset process', function () {
    $response = $this->post(route('password.email'), []);
    $response->assertSessionHasErrors('email');
});
test('valid email is required to start the password reset process', function () {
    $response = $this->post(route('password.email'), [
        'email' => 'invalid-email',
    ]);
    $response->assertSessionHasErrors('email');
});
