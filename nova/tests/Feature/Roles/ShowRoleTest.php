<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class ShowRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = create(Role::class);
    }

    /** @test **/
    public function authorizedUserCanViewARole()
    {
        $this->signInWithPermission('role.view');

        $response = $this->get(route('roles.show', $this->role));
        $response->assertSuccessful();
        $response->assertViewHas('role', $this->role);
    }

    /** @test **/
    public function unauthorizedUserCannotViewARole()
    {
        $this->signIn();

        $response = $this->get(route('roles.show', $this->role));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewARole()
    {
        $response = $this->getJson(route('roles.show', $this->role));
        $response->assertUnauthorized();
    }
}
