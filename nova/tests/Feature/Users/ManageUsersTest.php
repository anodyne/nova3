<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorizedUserCanManageUsers()
    {
        $this->signInWithAbility('user.create');

        $this->get(route('users.index'))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotManageThemes()
    {
        $this->signIn();

        $this->get(route('users.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotManageUsers()
    {
        $this->get(route('users.index'))
            ->assertRedirect(route('login'));
    }

    public function testPendingUsersAreShown()
    {
        $this->markTestIncomplete();
    }
}
