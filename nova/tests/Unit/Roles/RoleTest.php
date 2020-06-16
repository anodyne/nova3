<?php

namespace Tests\Unit\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = create(Role::class);
    }

    /** @test **/
    public function itCanGiveAUserTheRole()
    {
        $this->role->giveToUser($user = create(User::class));

        $this->assertTrue($user->hasRole($this->role->name));
    }
}
