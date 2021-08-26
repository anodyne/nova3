<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Nova\Users\Actions\UpdateUserStatus;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\User;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

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

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itCanTransitionFromPendingToActive()
    {
        $user = User::factory()->create();

        $this->action->execute($this->user, Active::class);

        $this->assertEquals($this->user->status, Active::class);
    }

    /** @test **/
    public function itCanTransitionFromPendingToInactive()
    {
        $user = User::factory()->create();

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
        $user = User::factory()->inactive()->create();

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
