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

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create();
    }

    /** @test **/
    public function authorizedUserWithCreatePermissionCanManageRoles()
    {
        $this->signInWithPermission('role.create');

        $response = $this->get(route('roles.index'));
        $response->assertOk();

        $response->assertHasProp('roles.can');
        $response->assertHasProp('roles.data');
        $response->assertHasProp('roles.links');
        $response->assertHasProp('roles.meta');
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanManageRoles()
    {
        $this->signInWithPermission('role.update');

        $response = $this->get(route('roles.index'));
        $response->assertOk();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanManageRoles()
    {
        $this->signInWithPermission('role.delete');

        $response = $this->get(route('roles.index'));
        $response->assertOk();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanManageRoles()
    {
        $this->signInWithPermission('role.view');

        $response = $this->get(route('roles.index'));
        $response->assertOk();
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

        factory(Role::class)->create([
            'display_name' => 'Another User Role',
        ]);

        $response = $this->get(route('roles.index') . '?search=user');

        $response->assertSuccessful();
        $response->assertPropCount('roles.data', 2);
        $response->assertPropValue('roles.data', function ($roles) {
            $this->assertEquals('Another User Role', $roles[0]['display_name']);
        });
    }

    /** @test **/
    public function rolesCanBeFilteredByName()
    {
        $this->signInWithPermission('role.create');

        factory(Role::class)->create([
            'name' => 'foo',
        ]);

        $response = $this->get(route('roles.index') . '?search=foo');

        $response->assertSuccessful();
        $response->assertPropCount('roles.data', 1);
        $response->assertPropValue('roles.data', function ($roles) {
            $this->assertEquals('foo', $roles[0]['name']);
        });
    }
}
