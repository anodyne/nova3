<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses()->group('auth');

describe('unauthenticated user', function () {
    test('can view the sign in form', function () {
        get(route('login'))->assertSuccessful();
    });

    test('can sign in with correct credentials', function () {
        $user = createUser();

        post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ])
            ->assertRedirectToRoute('dashboard');

        assertAuthenticatedAs($user);
    });

    test('can mark to remember their sign in', function () {
        $user = createUser();

        $response = post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
            'remember' => 'on',
        ]);

        $user = $user->fresh();

        $response->assertRedirectToRoute('dashboard')
            ->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
                $user->id,
                $user->getRememberToken(),
                $user->password,
            ]));

        assertAuthenticatedAs($user);
    });

    test('cannot sign in with an incorrect password', function () {
        $user = createUser();

        from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'invalid-password',
            ])
            ->assertRedirectToRoute('login')
            ->assertSessionHasErrors('email');

        assertTrue(session()->hasOldInput('email'));
        assertFalse(session()->hasOldInput('password'));

        assertGuest();
    });

    test('cannot sign in with an email address that does not exist', function () {
        from(route('login'))
            ->post(route('login'), [
                'email' => 'nobody@example.com',
                'password' => 'invalid-password',
            ])
            ->assertRedirectToRoute('login')
            ->assertSessionHasErrors('email');

        assertTrue(session()->hasOldInput('email'));
        assertFalse(session()->hasOldInput('password'));

        assertGuest();
    });

    test('cannot sign out when not signed in', function () {
        post(route('logout'))->assertRedirect('/');

        assertGuest();
    });

    test('is locked out after 5 unsuccessful sign in attempts', function () {
        $user = createUser();

        foreach (range(0, 5) as $_) {
            $response = from(route('login'))
                ->post(route('login'), [
                    'email' => $user->email,
                    'password' => 'invalid-password',
                ]);
        }

        $response->assertTooManyRequests();
    });
});

describe('authenticated user', function () {
    test('is redirected to the dashboard when trying to view the sign in page', function () {
        signIn()
            ->get(route('login'))
            ->assertRedirectToRoute('dashboard');
    });

    test('can sign out', function () {
        signIn();

        post(route('logout'))->assertRedirect('/');

        assertGuest();
    });
});
