<?php

declare(strict_types=1);

namespace Tests\Unit\Roles\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\Actions\CreateRole;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Permission;
use Tests\TestCase;

/**
 * @group roles
 */
class CreateRoleActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();
    }

    /** @test **/
    public function itCreatesARole()
    {
        $data = new RoleData(
            name: 'foo',
            display_name: 'Foo',
            description: 'Description of foo',
            default: false,
        );

        $role = CreateRole::run($data);

        $this->assertTrue($role->exists);
        $this->assertEquals('Foo', $role->display_name);
        $this->assertEquals('foo', $role->name);
        $this->assertEquals('Description of foo', $role->description);
        $this->assertFalse($role->default);
    }

    /** @test **/
    public function itCanAddPermissions()
    {
        $data = new RoleData(
            display_name: 'Bar',
            name: 'bar',
            default: false,
            permissions: Permission::whereIn('id', [1, 2, 3])->get(),
        );

        $role = CreateRole::run($data);

        $this->assertTrue($role->permissions->contains('id', 1));
        $this->assertTrue($role->permissions->contains('id', 2));
        $this->assertTrue($role->permissions->contains('id', 3));
    }
}
