<?php

use Nova\Users\Actions\ForcePasswordReset;

uses()->group('feature', 'auth');

test('guest can view the login page')
    ->get('/login')
    ->assertSuccessful();

test('authenticated user cannot view the login page')
    ->signIn()
    ->get('/login')
    ->assertRedirect('/');

test('guest can login with correct credentials', function () {
    $user = $this->createUser();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'secret',
    ]);
    $response->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});

test('guest cannot login with non-existent email address', function () {
    $response = $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'go-away@example.com',
            'password' => 'secret',
        ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('errors');

    $this->assertTrue(session()->hasOldInput('email'));
    $this->assertFalse(session()->hasOldInput('password'));

    $this->assertGuest();
});

test('guest cannot login with incorrect password', function () {
    $user = $this->createUser();

    $response = $this->from(route('login'))
        ->post(route('login'), [
            'email' => $user->email,
            'password' => 'foo',
        ]);

    $response->assertRedirect(route('login'));

    $this->assertTrue(session()->hasOldInput('email'));
    $this->assertFalse(session()->hasOldInput('password'));

    $this->assertGuest();
});

test('authenticated user can logout', function () {
    $this->signIn();

    $response = $this->post(route('logout'));
    $response->assertRedirect('/');

    $this->assertGuest();
});

test('guest cannot logout', function () {
    $response = $this->post(route('logout'));
    $response->assertRedirect('/');

    $this->assertGuest();
});

test('guest cannot attempt logging in more than 5 times in 1 minute', function () {
    $user = $this->createUser();

    foreach (range(0, 5) as $_) {
        $response = $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'invalid-password',
            ]);
    }

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');

    $this->assertStringContainsString(
        'Too many login attempts.',
        collect($response
            ->baseResponse
            ->getSession()
            ->get('errors')
            ->getBag('default')
            ->get('email'))->first()
    );

    $this->assertTrue(session()->hasOldInput('email'));
    $this->assertFalse(session()->hasOldInput('password'));

    $this->assertGuest();
});

test('timestamp is recorded when a user logs in', function () {
    $user = $this->createUser();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'secret',
    ]);

    $timeFormat = 'Y-m-d H:i';

    $this->assertEquals(
        now()->format($timeFormat),
        $user->fresh()->last_login->format($timeFormat),
        'Login timestamps do not match'
    );
});

test('user is prompted to change their password if an admin has forced a reset', function () {
    $user = $this->createUser();
    app(ForcePasswordReset::class)->execute($user);

    $this->followingRedirects();

    $response = $this->from(route('login'))
        ->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);

    $response->assertSeeText('An admin has required you to reset your password.');
});
