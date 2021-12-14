<?php

declare(strict_types=1);

namespace Tests\Unit\Roles\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\Actions\UpdateRoleUsers;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group roles
 */
class UpdateRoleUsersActionTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    protected $john;

    protected $jane;

    protected $ryan;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->role = Role::factory()->create();

        $this->john = User::factory()->active()->create();
        $this->jane = User::factory()->active()->create();
        $this->ryan = User::factory()->active()->create();
    }

    /** @test **/
    public function itCanAddUsers()
    {
        $this->john->attachRole($this->role);

        $data = new RoleAssignmentData();
        $data->role = $this->role;
        $data->users = User::whereIn('id', [
            $this->john->id,
            $this->jane->id,
        ])->get();

        UpdateRoleUsers::run($data);

        $this->role->refresh();

        $this->assertCount(2, $this->role->users);
        $this->assertTrue($this->role->users->contains('id', $this->john->id));
        $this->assertTrue($this->role->users->contains('id', $this->jane->id));
        $this->assertFalse($this->role->users->contains('id', $this->ryan->id));
    }

    /** @test **/
    public function itCanRemovePermissions()
    {
        $this->john->attachRole($this->role);
        $this->jane->attachRole($this->role);

        $data = new RoleAssignmentData();
        $data->role = $this->role;
        $data->users = User::whereIn('id', [$this->jane->id])->get();

        UpdateRoleUsers::run($data);

        $this->role->refresh();

        $this->assertCount(1, $this->role->users);
        $this->assertFalse($this->role->users->contains('id', $this->john->id));
        $this->assertTrue($this->role->users->contains('id', $this->jane->id));
        $this->assertFalse($this->role->users->contains('id', $this->ryan->id));
    }

    /** @test **/
    public function itCanAddAndRemovePermissions()
    {
        $this->john->attachRole($this->role);
        $this->jane->attachRole($this->role);

        $data = new RoleAssignmentData();
        $data->role = $this->role;
        $data->users = User::whereIn('id', [
            $this->john->id,
            $this->ryan->id,
        ])->get();

        UpdateRoleUsers::run($data);

        $this->role->refresh();

        $this->assertCount(2, $this->role->users);
        $this->assertTrue($this->role->users->contains('id', $this->john->id));
        $this->assertFalse($this->role->users->contains('id', $this->jane->id));
        $this->assertTrue($this->role->users->contains('id', $this->ryan->id));
    }
}
