<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Silber\Bouncer\Database\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageRolesTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create();
    }

    public function testUserCanViewManageRolesPage()
    {
        $this->signInWithAbility('role.create');

        $this->get(route('roles.index'))
            ->assertSuccessful();
    }

    public function testUnauthorizedUsersCannotManageRoles()
    {
        $this->get(route('roles.index'))->assertRedirect(route('login'));
    }
}
