<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class ReorderRolesTest extends TestCase
{
    use RefreshDatabase;

    protected $role1;

    protected $role2;

    protected $role3;

    public function setUp(): void
    {
        parent::setUp();

        $this->role1 = Role::factory()->create(['sort' => 0]);
        $this->role2 = Role::factory()->create(['sort' => 1]);
        $this->role3 = Role::factory()->create(['sort' => 2]);
    }

    /** @test **/
    public function authorizedUserCanReorderRoles()
    {
        $this->signInWithPermission('role.update');

        $this->followingRedirects();

        $response = $this->post(
            route('roles.reorder'),
            [
                'sort' => implode(',', [
                    $this->role3->id,
                    $this->role2->id,
                    $this->role1->id,
                ]),
            ]
        );
        $response->assertSuccessful();

        $this->role1->fresh();
        $this->role2->fresh();
        $this->role3->fresh();

        $this->assertDatabaseHas('roles', [
            'id' => $this->role1->id,
            'sort' => 2,
        ]);
        $this->assertDatabaseHas('roles', [
            'id' => $this->role2->id,
            'sort' => 1,
        ]);
        $this->assertDatabaseHas('roles', [
            'id' => $this->role3->id,
            'sort' => 0,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotReorderRoles()
    {
        $this->signIn();

        $response = $this->post(
            route('roles.reorder'),
            [
                'sort' => implode(',', [
                    $this->role3->id,
                    $this->role2->id,
                    $this->role1->id,
                ]),
            ]
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotReorderRoles()
    {
        $response = $this->postJson(
            route('roles.reorder'),
            [
                'sort' => implode(',', [
                    $this->role3->id,
                    $this->role2->id,
                    $this->role1->id,
                ]),
            ]
        );
        $response->assertUnauthorized();
    }
}
