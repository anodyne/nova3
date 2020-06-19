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

        $this->role = create(Role::class);
    }

    /** @test **/
    public function itCanGiveAUserTheRole()
    {
        $this->role->giveToUser($user = create(User::class, [], ['status:active']));

        $this->assertTrue($user->hasRole($this->role->name));
    }
}
