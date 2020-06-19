<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Actions\UpdateUserStatus;
use Spatie\ModelStates\Exceptions\TransitionNotFound;

/**
 * @group users
 */
class UpdateUserStatusActionTest extends TestCase
{
    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateUserStatus::class);

        $this->user = create(User::class, [], ['status:active']);
    }

    /** @test **/
    public function itCanTransitionFromPendingToActive()
    {
        $user = create(User::class);

        $this->action->execute($this->user, Active::class);

        $this->assertEquals($this->user->status, Active::class);
    }

    /** @test **/
    public function itCanTransitionFromPendingToInactive()
    {
        $user = create(User::class);

        $this->action->execute($this->user, Inactive::class);

        $this->assertEquals($this->user->status, Inactive::class);
    }

    /** @test **/
    public function itCanTransitionFromActiveToInactive()
    {
        $this->action->execute($this->user, Inactive::class);

        $this->assertEquals($this->user->status, Inactive::class);
    }

    /** @test **/
    public function itCanTransitionFromInactiveToActive()
    {
        $user = create(User::class, [], ['status:inactive']);

        $this->action->execute($this->user, Active::class);

        $this->assertEquals($this->user->status, Active::class);
    }

    /** @test **/
    public function itThrowsAnExceptionIfTheUserCannotBeTransitionedToTheStatus()
    {
        $this->expectException(TransitionNotFound::class);

        $this->action->execute($this->user, Pending::class);

        $this->assertNotEquals($this->user->status, Pending::class);
    }
}
