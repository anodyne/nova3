<?php

namespace Tests\Unit\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Actions\UpdateRoleUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateRoleUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $role;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateRoleUsers::class);

        $this->user = factory(User::class)->create();

        $this->role = factory(Role::class)->create();

        config(['laratrust.cache.enabled' => false]);
    }

    /** @test **/
    public function itCanGiveUserARole()
    {
        $this->assertFalse($this->user->hasRole($this->role->name));

        $this->action->execute(new RoleAssignmentData([
            'role' => $this->role,
            'users' => User::whereIn('id', [$this->user->id])->get(),
        ]));

        $this->assertTrue($this->user->refresh()->hasRole($this->role->name));
    }

    /** @test **/
    public function itCanRevokeRoleFromUser()
    {
        $this->user->attachRole($this->role->name);

        $this->assertTrue($this->user->hasRole($this->role->name));

        $this->action->execute(new RoleAssignmentData([
            'role' => $this->role,
            'users' => collect(),
        ]));

        $this->assertFalse($this->user->refresh()->hasRole($this->role->name));
    }
}
