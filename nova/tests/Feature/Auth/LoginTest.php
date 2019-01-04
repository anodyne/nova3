<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_can_view_the_login_page()
    {
        $this->get(route('login'))
            ->assertSuccessful();
    }

    /** @test **/
    public function a_user_cannot_view_the_login_page_when_they_are_authenticated()
    {
        $this->signIn();

        $this->get(route('login'))
            ->assertRedirect(route('home'));
    }

    /** @test **/
    public function a_user_can_login_with_correct_credentials()
    {
        $user = $this->createUser();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret'
            ])
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test **/
    public function a_user_cannot_login_with_non_existent_email()
    {
        $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'go-away@example.com',
                'password' => 'secret'
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    /** @test **/
    public function a_user_cannot_login_with_incorrect_password()
    {
        $user = $this->createUser();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'foo'
            ])
            ->assertRedirect(route('login'));

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    /** @test **/
    public function an_authenticated_user_can_logout()
    {
        $this->signIn();

        $this->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test **/
    public function an_unauthenticated_user_cannot_logout()
    {
        $this->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test **/
    public function a_user_cannot_attempt_more_than_five_logins_in_one_minute()
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

        $this->assertContains(
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
    public function a_timestamp_is_recorded_when_a_user_logs_in()
    {
        $user = $this->createUser();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret'
            ]);

        $timeFormat = 'Y-m-d H:i';

        $this->assertEquals(
            now()->format($timeFormat),
            $user->fresh()->last_login->format($timeFormat),
            'Login timestamps do not match'
        );
    }

    /** @test **/
    public function a_user_is_prompted_to_change_their_password_if_an_admin_has_forced_a_reset()
    {
        $user = $this->createUser();
        $user->forcePasswordReset();

        $this->followingRedirects()
            ->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'secret'
            ])
            ->assertSeeText('An admin has required you to reset your password.');
    }
}
