<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Models\States\Active;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;

/**
 * @see \Nova\Users\Http\Controllers\ShowUserController
 */
class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $activeUser;

    protected $pendingUser;

    protected $inactiveUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->activeUser = factory(User::class)->create();

        $this->pendingUser = factory(User::class)->state('status:pending')->create();

        $this->inactiveUser = factory(User::class)->state('status:inactive')->create();
    }

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.create');

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.update');

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.delete');

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageUsersPage()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function manageUsersPageCanShowAllUsers()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();

        $this->assertCount(User::count(), $response['users']);
    }

    /** @test **/
    public function manageUsersPageCanShowOnlyActiveUsers()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index', 'status=active'));
        $response->assertSuccessful();

        $this->assertCount(
            User::whereState('status', Active::class)->count(),
            $response['users']
        );
    }

    /** @test **/
    public function manageUsersPageCanShowOnlyPendingUsers()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index', 'status=pending'));
        $response->assertSuccessful();

        $this->assertCount(
            User::whereState('status', Pending::class)->count(),
            $response['users']
        );
    }

    /** @test **/
    public function manageUsersPageCanShowOnlyInactiveUsers()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index', 'status=inactive'));
        $response->assertSuccessful();

        $this->assertCount(
            User::whereState('status', Inactive::class)->count(),
            $response['users']
        );
    }

    /** @test **/
    public function usersCanBeFilteredByName()
    {
        $this->signInWithPermission('user.create');

        $this->createUser([
            'name' => 'Sparrow Capitan',
        ]);

        $this->createUser();

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();

        $this->assertCount(User::count(), $response['users']);

        $response = $this->get(route('users.index', 'search=sparrow'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['users']);
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
        $response->assertSuccessful();

        $this->assertCount(User::count(), $response['users']);

        $response = $this->get(route('users.index', 'search=john@example.com'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['users']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageUsersPage()
    {
        $this->signIn();

        $response = $this->get(route('users.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageUsersPage()
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }
}
