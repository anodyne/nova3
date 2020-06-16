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
        $user = create(User::class);

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
        $user = create(User::class);

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
        $user = create(User::class);

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
        $user = create(User::class);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $timeFormat = 'Y-m-d H:i';

        $this->assertCount(1, $user->refresh()->logins);

        $this->assertDatabaseHas('logins', [
            'user_id' => $user->id,
        ]);
    }

    /** @test **/
    public function userIsPromptedToChangeTheirPasswordIfAnAdminHasForcedReset()
    {
        app(ForcePasswordReset::class)->execute(
            $user = create(User::class)
        );

        $this->followingRedirects();

        $response = $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret',
            ]);

        $response->assertSeeText('An admin has required you to reset your password.');
    }
}
