<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Models\States\Inactive;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group users
 */
class DeactivateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeactivateUser::class);

        $this->user = create(User::class, [], ['status:active']);
    }

    /** @test **/
    public function itDeactivatesAUser()
    {
        $user = $this->action->execute($this->user);

        $this->assertTrue($user->status->equals(Inactive::class));
    }
}
