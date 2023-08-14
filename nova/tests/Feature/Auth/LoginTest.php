<?php

declare(strict_types=1);
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Models\User;
test('unauthenticated user can view login page', function () {
    $response = $this->get(route('login'));
    $response->assertSuccessful();
});
test('user can login with correct credentials', function () {
    $user = User::factory()->active()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'secret',
    ]);
    $response->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});
test('authenticated user cannot view login page', function () {
    $this->signIn();

    $response = $this->get(route('login'));
    $response->assertRedirect(route('home'));
});
test('user cannot login with non existent email', function () {
    $response = $this->post(route('login'), [
        'email' => 'go-away@example.com',
        'password' => 'secret',
    ]);
    $response->assertSessionHas('errors');

    expect(session()->hasOldInput('email'))->toBeTrue();
    expect(session()->hasOldInput('password'))->toBeFalse();

    $this->assertGuest();
});
test('user cannot login with incorrect password', function () {
    $user = User::factory()->active()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'foo',
    ]);

    expect(session()->hasOldInput('email'))->toBeTrue();
    expect(session()->hasOldInput('password'))->toBeFalse();

    $this->assertGuest();
});
test('authenticated user can logout', function () {
    $this->signIn();

    $response = $this->post(route('logout'));

    $this->assertGuest();
});
test('unauthenticated user cannot logout', function () {
    $response = $this->post(route('logout'));

    $this->assertGuest();
});
test('user cannot attempt logging in more than five times in one minute', function () {
    $user = User::factory()->active()->create();

    foreach (range(0, 5) as $_) {
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);
    }

    $response->assertSessionHasErrors('email');

    $this->assertStringContainsString(
        'Too many login attempts.',
        collect(
            $response
                ->baseResponse
                ->getSession()
                ->get('errors')
                ->getBag('default')
                ->get('email')
        )->first()
    );

    expect(session()->hasOldInput('email'))->toBeTrue();
    expect(session()->hasOldInput('password'))->toBeFalse();

    $this->assertGuest();
});
test('timestamp is recorded when user logs in', function () {
    $user = User::factory()->active()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'secret',
    ]);

    expect($user->refresh()->logins)->toHaveCount(1);

    $this->assertDatabaseHas('logins', [
        'user_id' => $user->id,
    ]);
});
test('user is signed out and redirected to change their password if an admin has forced a password reset', function () {
    ForcePasswordReset::run(
        $user = User::factory()->active()->create()
    );

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'secret',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('password.request'));
});
