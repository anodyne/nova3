<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\UpdateUserRoles;

class UpdateUserRolesActionTest extends TestCase
{
    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateUserRoles::class);

        $this->user = factory(User::class)->create();
    }

    /** @test **/
    public function itCanAddRolesToAUser()
    {
        //
    }

    /** @test **/
    public function itCanRemoveRolesFromAUser()
    {
        //
    }
}
