<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Roles\Http\Controllers\RoleController
 */
class ManageRolesTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanManageRoles()
    {
        $this->signInWithPermission('role.create');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanManageRoles()
    {
        $this->signInWithPermission('role.update');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanManageRoles()
    {
        $this->signInWithPermission('role.delete');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanManageRoles()
    {
        $this->signInWithPermission('role.view');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotManageRoles()
    {
        $this->signIn();

        $response = $this->getJson(route('roles.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotManageRoles()
    {
        $response = $this->getJson(route('roles.index'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function rolesCanBeFilteredByDisplayName()
    {
        $this->signInWithPermission('role.create');

        create(Role::class, [
            'display_name' => 'Another User Role',
        ]);

        $response = $this->get(route('roles.index') . '?search=user');
        $response->assertSuccessful();

        $this->assertCount(2, $response['roles']);
    }

    /** @test **/
    public function rolesCanBeFilteredByName()
    {
        $this->signInWithPermission('role.create');

        create(Role::class, [
            'name' => 'foo',
        ]);

        $response = $this->get(route('roles.index') . '?search=foo');
        $response->assertSuccessful();

        $this->assertCount(1, $response['roles']);
    }
}
