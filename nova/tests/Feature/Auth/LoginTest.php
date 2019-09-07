<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewLoginPage()
    {
        $this->get(route('login'))
            ->assertSuccessful();
    }

    public function testAuthenticatedUserCannotViewLoginPage()
    {
        $this->signIn();

        $this->get(route('login'))
            ->assertRedirect(route('home'));
    }

    public function testGuestCanLoginWithCorrectCredentials()
    {
        $user = $this->createUser();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret',
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function testGuestCannotLoginWithNonExistentEmail()
    {
        $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'go-away@example.com',
                'password' => 'secret',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    public function testGuestCannotLoginWithIncorrectPassword()
    {
        $user = $this->createUser();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'foo',
            ])
            ->assertRedirect(route('login'));

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    public function testAuthenticatedUserCanLogout()
    {
        $this->signIn();

        $this->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function testGuestCannotLogout()
    {
        $this->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function testGuestCannotAttemptLoggingInMoreThanFiveTimesInOneMinute()
    {
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
    }

    public function testTimestampIsRecordedWhenUserLogsIn()
    {
        $user = $this->createUser();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret',
            ]);

        $timeFormat = 'Y-m-d H:i';

        $this->assertEquals(
            now()->format($timeFormat),
            $user->fresh()->last_login->format($timeFormat),
            'Login timestamps do not match'
        );
    }

    public function testUserIsPromptedToChangeTheirPasswordIfAnAdminHasForcedReset()
    {
        $user = $this->createUser();
        $user->forcePasswordReset();

        $this->followingRedirects()
            ->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret',
            ])
            ->assertSeeText('An admin has required you to reset your password.');
    }
}
