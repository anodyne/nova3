<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Http\Response;
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

    public function testAuthorizedUserCanManageRoles()
    {
        $this->signInWithPermission('role.create');

        $this->get(route('roles.index'))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotManageRoles()
    {
        $this->signIn();

        $this->get(route('roles.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotManageRoles()
    {
        $this->get(route('roles.index'))
            ->assertRedirect(route('login'));
    }
}
