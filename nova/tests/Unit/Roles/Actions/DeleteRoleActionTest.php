<?php

declare(strict_types=1);

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

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = Role::factory()->create();
    }

    /** @test **/
    public function itDeletesARole()
    {
        $role = DeleteRole::run($this->role);

        $this->assertFalse($role->exists);
    }
}
