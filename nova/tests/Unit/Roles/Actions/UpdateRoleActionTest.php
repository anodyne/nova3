<?php

declare(strict_types=1);

namespace Tests\Unit\Roles\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\Actions\UpdateRole;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;
use Tests\TestCase;

/**
 * @group roles
 */
class UpdateRoleActionTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->role = Role::factory()->create();
    }

    /** @test **/
    public function itCanUpdateARole()
    {
        $data = RoleData::from([
            'name' => 'foo',
            'display_name' => 'Foo',
            'description' => 'New description of foo',
            'default' => true,
        ]);

        $role = UpdateRole::run($this->role, $data);

        $this->assertEquals('foo', $role->name);
        $this->assertEquals('Foo', $role->display_name);
        $this->assertEquals('New description of foo', $role->description);
        $this->assertTrue($role->default);
    }
}
