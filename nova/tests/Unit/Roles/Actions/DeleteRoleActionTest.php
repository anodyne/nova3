<?php

namespace Tests\Unit\Roles\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Models\Role;
use Tests\TestCase;

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

        $this->role = create(Role::class);
    }

    /** @test **/
    public function itDeletesARole()
    {
        $role = $this->action->execute($this->role);

        $this->assertFalse($role->exists);
    }
}
