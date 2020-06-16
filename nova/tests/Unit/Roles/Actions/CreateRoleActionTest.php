<?php

namespace Tests\Unit\Roles\Actions;

use Tests\TestCase;
use Nova\Roles\Models\Permission;
use Nova\Roles\Actions\CreateRole;
use Nova\Roles\DataTransferObjects\RoleData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class CreateRoleActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->action = app(CreateRole::class);
    }

    /** @test **/
    public function itCreatesARole()
    {
        $data = new RoleData;
        $data->name = 'foo';
        $data->display_name = 'Foo';
        $data->description = 'Description of foo';
        $data->default = false;

        $role = $this->action->execute($data);

        $this->assertTrue($role->exists);
        $this->assertEquals('Foo', $role->display_name);
        $this->assertEquals('foo', $role->name);
        $this->assertEquals('Description of foo', $role->description);
        $this->assertFalse($role->default);
    }

    /** @test **/
    public function itCanAddPermissions()
    {
        $data = new RoleData;
        $data->display_name = 'Bar';
        $data->name = 'bar';
        $data->default = false;
        $data->permissions = Permission::whereIn('id', [1, 2, 3])->get();

        $role = $this->action->execute($data);

        $this->assertTrue($role->permissions->contains('id', 1));
        $this->assertTrue($role->permissions->contains('id', 2));
        $this->assertTrue($role->permissions->contains('id', 3));
    }
}
