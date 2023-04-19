<?php

declare(strict_types=1);

namespace Tests\Feature\Roles;

use Nova\Roles\Models\Role;
use Tests\TestCase;

/**
 * @group roles
 */
class ShowRoleTest extends TestCase
{
    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = Role::factory()->create();
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
