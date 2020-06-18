<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\States\Inactive;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->activeUser = create(User::class, [], ['status:active']);

        $this->pendingUser = create(User::class);

        $this->inactiveUser = create(User::class, [], ['status:inactive']);
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

        $this->assertEquals(User::count(), $response['users']->total());
    }

    /** @test **/
    public function manageUsersPageCanShowOnlyActiveUsers()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index', 'status=active'));
        $response->assertSuccessful();

        $this->assertEquals(
            User::whereState('status', Active::class)->count(),
            $response['users']->total()
        );
    }

    /** @test **/
    public function manageUsersPageCanShowOnlyPendingUsers()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index', 'status=pending'));
        $response->assertSuccessful();

        $this->assertEquals(
            User::whereState('status', Pending::class)->count(),
            $response['users']->total()
        );
    }

    /** @test **/
    public function manageUsersPageCanShowOnlyInactiveUsers()
    {
        $this->signInWithPermission('user.view');

        $response = $this->get(route('users.index', 'status=inactive'));
        $response->assertSuccessful();

        $this->assertEquals(
            User::whereState('status', Inactive::class)->count(),
            $response['users']->total()
        );
    }

    /** @test **/
    public function usersCanBeFilteredByName()
    {
        $this->signInWithPermission('user.create');

        create(User::class, [
            'name' => 'Sparrow Capitan',
        ], ['status:active']);

        create(User::class, [], ['status:active']);

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();

        $this->assertEquals(User::count(), $response['users']->total());

        $response = $this->get(route('users.index', 'search=sparrow'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['users']);
    }

    /** @test **/
    public function usersCanBeFilteredByEmail()
    {
        $this->signInWithPermission('user.create');

        create(User::class, [
            'email' => 'sparrow@example.com',
        ], ['status:active']);

        create(User::class, [], ['status:active']);

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();

        $this->assertEquals(User::count(), $response['users']->total());

        $response = $this->get(route('users.index', 'search=sparrow@example.com'));
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
