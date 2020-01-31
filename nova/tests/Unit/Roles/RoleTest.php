<?php

namespace Tests\Unit\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create();
    }

    /** @test **/
    public function itCanGiveAUserTheRole()
    {
        $this->role->giveToUser($user = $this->createUser());

        $this->assertTrue($user->hasRole($this->role->name));
    }
}
