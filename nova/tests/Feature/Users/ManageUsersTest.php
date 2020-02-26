<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Users\Http\Controllers\UserController
 */
class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.create');

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertHasProp('users.can');
        $response->assertHasProp('users.data');
        $response->assertHasProp('users.links');
        $response->assertHasProp('users.meta');
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.update');

        $response = $this->get(route('users.index'));
        $response->assertOk();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.delete');

        $response = $this->get(route('users.index'));
        $response->assertOk();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index'));
        $response->assertOk();
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageUsersPage()
    {
        $this->signIn();

        $response = $this->getJson(route('users.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotViewManageUsersPage()
    {
        $response = $this->getJson(route('users.index'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function usersCanBeFilteredByName()
    {
        $this->signInWithPermission('user.create');

        $this->createUser([
            'name' => 'John Public',
        ]);

        $this->createUser();

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertPropCount('users.data', 3);

        $response = $this->get(route('users.index') . '?search=john');

        $response->assertOk();
        $response->assertPropCount('users.data', 1);
        $response->assertPropValue('users.data', function ($users) {
            $this->assertEquals('John Public', $users[0]['name']);
        });
    }

    /** @test **/
    public function usersCanBeFilteredByEmail()
    {
        $this->signInWithPermission('user.create');

        $this->createUser([
            'email' => 'john@example.com',
        ]);

        $this->createUser();

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertPropCount('users.data', 3);

        $response = $this->get(route('users.index') . '?search=john@example.com');

        $response->assertOk();
        $response->assertPropCount('users.data', 1);
        $response->assertPropValue('users.data', function ($users) {
            $this->assertEquals('john@example.com', $users[0]['email']);
        });
    }
}
