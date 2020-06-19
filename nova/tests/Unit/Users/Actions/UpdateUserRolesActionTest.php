<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Users\Actions\UpdateUserRoles;

/**
 * @group users
 * @group roles
 */
class UpdateUserRolesActionTest extends TestCase
{
    protected $action;

    protected $role;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateUserRoles::class);

        $this->user = create(User::class, [], ['status:active']);

        $this->role = create(Role::class);
    }

    /** @test **/
    public function itCanAddRolesToAUser()
    {
        $this->assertCount(0, $this->user->roles);

        $this->action->execute($this->user, collect([$this->role]));

        $this->assertCount(1, $this->user->refresh()->roles);
        $this->assertTrue($this->user->hasRole($this->role->name));
    }

    /** @test **/
    public function itCanRemoveRolesFromAUser()
    {
        $this->user->attachRole($this->role);

        $this->assertCount(1, $this->user->refresh()->roles);
        $this->assertTrue($this->user->hasRole($this->role->name));

        $this->action->execute($this->user, collect());

        $this->assertCount(0, $this->user->refresh()->roles);
        $this->assertFalse($this->user->hasRole($this->role->name));
    }
}
