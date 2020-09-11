<?php

namespace Tests\Unit\Roles\Actions;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Roles\Actions\DuplicateRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class DuplicateRoleActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateRole::class);

        $this->role = Role::factory()->create();
        $this->role->attachPermissions([1, 2]);
    }

    /** @test **/
    public function itDuplicatesARole()
    {
        $role = $this->action->execute($this->role);

        $this->assertEquals(
            "Copy of {$this->role->display_name}",
            $role->display_name
        );
        $this->assertEquals(
            $this->role->permissions->count(),
            $role->permissions->count()
        );
    }
}
