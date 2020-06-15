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

    /**
     * @var  Role
     */
    protected $role;

    /**
     * @var  User
     */
    protected $user;

    /**
     * @var  UpdateRoleUsers
     */
    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        $this->role = Role::create(['name' => 'test-role']);

        $this->action = new UpdateRoleUsers;
    }

    /** @test **/
    public function itCanGiveUserARole()
    {
        $this->assertFalse($this->user->isA('test-role'));

        $this->action->execute(new RoleAssignmentData([
            'role' => $this->role,
            'users' => User::whereIn('id', [$this->user->id])->get(),
        ]));

        $this->assertTrue($this->user->isA('test-role'));
    }

    /** @test **/
    public function itCanRevokeRoleFromUser()
    {
        $this->user->attachRole('test-role');

        $this->assertTrue($this->user->isA('test-role'));

        $this->action->execute(new RoleAssignmentData([
            'role' => $this->role,
            'users' => collect(),
        ]));

        $this->assertFalse($this->user->isA('test-role'));
    }
}
