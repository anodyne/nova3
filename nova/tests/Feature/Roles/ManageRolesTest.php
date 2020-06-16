<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class ManageRolesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageRolesPage()
    {
        $this->signInWithPermission('role.create');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageRolesPage()
    {
        $this->signInWithPermission('role.update');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageRolesPage()
    {
        $this->signInWithPermission('role.delete');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageRolesPage()
    {
        $this->signInWithPermission('role.view');

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function rolesCanBeFilteredByDisplayName()
    {
        $this->signInWithPermission('role.create');

        create(Role::class, [
            'display_name' => 'barbaz',
        ]);

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();

        $this->assertEquals(Role::count(), $response['roles']->total());

        $response = $this->get(route('roles.index', 'search=barbaz'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['roles']);
    }

    /** @test **/
    public function rolesCanBeFilteredByName()
    {
        $this->signInWithPermission('role.create');

        create(Role::class, [
            'name' => 'foobar',
        ]);

        $response = $this->get(route('roles.index'));
        $response->assertSuccessful();

        $this->assertEquals(Role::count(), $response['roles']->total());

        $response = $this->get(route('roles.index', 'search=foobar'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['roles']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageRolesPage()
    {
        $this->signIn();

        $response = $this->get(route('roles.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageRolesPage()
    {
        $response = $this->getJson(route('roles.index'));
        $response->assertUnauthorized();
    }
}
