<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Nova\Users\Actions\ForcePasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function guestCanViewLoginPage()
    {
        $response = $this->get(route('login'));
        $response->assertOk();
    }

    /** @test **/
    public function authenticatedUserCannotViewLoginPage()
    {
        $this->signIn();

        $response = $this->get(route('login'));
        $response->assertRedirect(route('home'));
    }

    /** @test **/
    public function guestCanLoginWithCorrectCredentials()
    {
        $user = $this->createUser();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        $response->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test **/
    public function guestCannotLoginWithNonExistentEmail()
    {
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
    }

    /** @test **/
    public function guestCannotLoginWithIncorrectPassword()
    {
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
    }

    /** @test **/
    public function authenticatedUserCanLogout()
    {
        $this->signIn();

        $response = $this->post(route('logout'));
        $response->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test **/
    public function guestCannotLogout()
    {
        $response = $this->post(route('logout'));
        $response->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test **/
    public function guestCannotAttemptLoggingInMoreThanFiveTimesInOneMinute()
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

    /** @test **/
    public function timestampIsRecordedWhenUserLogsIn()
    {
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
    }

    /** @test **/
    public function userIsPromptedToChangeTheirPasswordIfAnAdminHasForcedReset()
    {
        $user = $this->createUser();
        app(ForcePasswordReset::class)->execute($user);

        $this->followingRedirects();

        $response = $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret',
            ]);

        $response->assertSeeText('An admin has required you to reset your password.');
    }
}
