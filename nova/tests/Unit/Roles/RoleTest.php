<?php

namespace Tests\Unit\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->role = Role::factory()->create();
    }

    /** @test **/
    public function itCanGiveAUserTheRole()
    {
        $this->role->giveToUser($user = User::factory()->active()->create());

        $this->assertTrue($user->hasRole($this->role->name));
    }
}
