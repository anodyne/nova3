<?php

namespace Tests\Unit\Roles\Actions;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Roles\Actions\DeleteRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class DeleteRoleActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteRole::class);

        $this->role = Role::factory()->create();
    }

    /** @test **/
    public function itDeletesARole()
    {
        $role = $this->action->execute($this->role);

        $this->assertFalse($role->exists);
    }
}
