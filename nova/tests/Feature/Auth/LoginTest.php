<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\ForcePasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function unauthenticatedUserCanViewLoginPage()
    {
        $response = $this->get(route('login'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function userCanLoginWithCorrectCredentials()
    {
        $user = create(User::class);

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
        $user = create(User::class);

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
        $user = create(User::class);

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
        $user = create(User::class);

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
    public function userIsPromptedToChangeTheirPasswordIfAnAdminHasForcedAPasswordReset()
    {
        app(ForcePasswordReset::class)->execute(
            $user = create(User::class)
        );

        $this->followingRedirects();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        $response->assertSeeText('An admin has required you to reset your password.');
    }
}
