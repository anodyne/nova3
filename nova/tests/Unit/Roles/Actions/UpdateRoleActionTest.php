<?php

namespace Tests\Unit\Roles\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\Actions\UpdateRole;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Tests\TestCase;

/**
 * @group roles
 */
class UpdateRoleActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->action = app(UpdateRole::class);

        $this->role = create(Role::class);
    }

    /** @test **/
    public function itCanUpdateARole()
    {
        $data = new RoleData;
        $data->name = 'foo';
        $data->display_name = 'Foo';
        $data->description = 'New description of foo';
        $data->default = true;

        $role = $this->action->execute($this->role, $data);

        $this->assertEquals('foo', $role->name);
        $this->assertEquals('Foo', $role->display_name);
        $this->assertEquals('New description of foo', $role->description);
        $this->assertTrue($role->default);
    }

    /** @test **/
    public function itCanAddPermissions()
    {
        $this->role->attachPermission(1);

        $data = new RoleData;
        $data->name = $this->role->name;
        $data->display_name = $this->role->display_name;
        $data->description = $this->role->description;
        $data->default = $this->role->default;
        $data->permissions = Permission::whereIn('id', [1, 2, 3])->get();

        $role = $this->action->execute($this->role, $data);

        $this->assertCount(3, $role->permissions);
        $this->assertTrue($role->permissions->contains('id', 1));
        $this->assertTrue($role->permissions->contains('id', 2));
        $this->assertTrue($role->permissions->contains('id', 3));
    }

    /** @test **/
    public function itCanRemovePermissions()
    {
        $this->role->attachPermissions([1, 2]);

        $data = new RoleData;
        $data->name = $this->role->name;
        $data->display_name = $this->role->display_name;
        $data->description = $this->role->description;
        $data->default = $this->role->default;
        $data->permissions = Permission::whereIn('id', [1])->get();

        $role = $this->action->execute($this->role, $data);

        $this->assertCount(1, $role->permissions);
        $this->assertTrue($role->permissions->contains('id', 1));
        $this->assertFalse($role->permissions->contains('id', 2));
    }

    /** @test **/
    public function itCanAddAndRemovePermissions()
    {
        $this->role->attachPermissions([1, 2]);

        $data = new RoleData;
        $data->name = $this->role->name;
        $data->display_name = $this->role->display_name;
        $data->description = $this->role->description;
        $data->default = $this->role->default;
        $data->permissions = Permission::whereIn('id', [1, 3])->get();

        $role = $this->action->execute($this->role, $data);

        $this->assertCount(2, $role->permissions);
        $this->assertTrue($role->permissions->contains('id', 1));
        $this->assertFalse($role->permissions->contains('id', 2));
        $this->assertTrue($role->permissions->contains('id', 3));
    }
}
