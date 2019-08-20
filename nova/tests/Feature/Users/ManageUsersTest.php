<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authorizedUserCanManageUsers()
    {
        $this->signInWithAbility('user.create');

        $response = $this->get(route('users.index'));

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function unauthorizedUserCannotManageThemes()
    {
        $this->signIn();

        $response = $this->get(route('users.index'));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function guestCannotManageUsers()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function pendingUsersAreShown()
    {
        $this->markTestIncomplete();
    }
}
