<?php

namespace Tests\Unit\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Actions\UpdateUsersRoles;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateUsersRolesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var  Role
     */
    protected $role;

    /**
     * @var  \Nova\Users\Models\User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        Bouncer::allow('test-role')->to('test-ability');

        $this->role = Role::whereName('test-role')->first();
    }

    /** @test **/
    public function itCanGiveUserARole()
    {
        $this->assertFalse($this->user->isA('test-role'));

        $data = new RoleAssignmentData;
        $data->role = $this->role;
        $data->users = User::whereIn('id', [$this->user->id])->get();

        (new UpdateUsersRoles)->execute($data);

        $this->assertTrue($this->user->isA('test-role'));
    }

    /** @test **/
    public function itCanRevokeRoleFromUser()
    {
        $this->user->assign('test-role');

        $this->assertTrue($this->user->isA('test-role'));

        $data = new RoleAssignmentData;
        $data->role = $this->role;
        $data->users = collect();

        (new UpdateUsersRoles)->execute($data);

        $this->assertFalse($this->user->isA('test-role'));
    }
}
