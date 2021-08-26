<?php

declare(strict_types=1);

namespace Tests\Unit\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Tests\TestCase;

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
