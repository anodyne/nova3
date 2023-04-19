<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group auth
 */
class LoginTest extends TestCase
{
    /** @test **/
    public function unauthenticatedUserCanViewLoginPage()
    {
        $response = $this->get(route('login'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function userCanLoginWithCorrectCredentials()
    {
        $user = User::factory()->active()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        $response->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test **/
    public function authenticatedUserCannotViewLoginPage()
    {
        $this->signIn();

        $response = $this->get(route('login'));
        $response->assertRedirect(route('home'));
    }

    /** @test **/
    public function userCannotLoginWithNonExistentEmail()
    {
        $response = $this->post(route('login'), [
            'email' => 'go-away@example.com',
            'password' => 'secret',
        ]);
        $response->assertSessionHas('errors');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    /** @test **/
    public function userCannotLoginWithIncorrectPassword()
    {
        $user = User::factory()->active()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'foo',
        ]);

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    /** @test **/
    public function authenticatedUserCanLogout()
    {
        $this->signIn();

        $response = $this->post(route('logout'));

        $this->assertGuest();
    }

    /** @test **/
    public function unauthenticatedUserCannotLogout()
    {
        $response = $this->post(route('logout'));

        $this->assertGuest();
    }

    /** @test **/
    public function userCannotAttemptLoggingInMoreThanFiveTimesInOneMinute()
    {
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

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    /** @test **/
    public function timestampIsRecordedWhenUserLogsIn()
    {
        $user = User::factory()->active()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $this->assertCount(1, $user->refresh()->logins);

        $this->assertDatabaseHas('logins', [
            'user_id' => $user->id,
        ]);
    }

    /** @test **/
    public function userIsSignedOutAndRedirectedToChangeTheirPasswordIfAnAdminHasForcedAPasswordReset()
    {
        ForcePasswordReset::run(
            $user = User::factory()->active()->create()
        );

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('password.request'));
    }
}
