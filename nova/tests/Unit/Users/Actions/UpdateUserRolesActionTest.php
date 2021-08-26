<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Nova\Roles\Models\Role;
use Nova\Users\Actions\UpdateUserRoles;
use Nova\Users\Models\User;
use Tests\TestCase;

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

        $this->user = User::factory()->active()->create();

        $this->role = Role::factory()->create();
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
