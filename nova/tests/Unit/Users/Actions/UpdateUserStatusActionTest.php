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

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itCanTransitionFromPendingToActive()
    {
        $user = User::factory()->create();

        UpdateUserStatus::run($user, Active::class);

        $this->assertInstanceOf(Active::class, $user->status);
    }

    /** @test **/
    public function itCanTransitionFromPendingToInactive()
    {
        $user = User::factory()->create();

        UpdateUserStatus::run($user, Inactive::class);

        $this->assertInstanceOf(Inactive::class, $user->status);
    }

    /** @test **/
    public function itCanTransitionFromActiveToInactive()
    {
        UpdateUserStatus::run($this->user, Inactive::class);

        $this->assertInstanceOf(Inactive::class, $this->user->status);
    }

    /** @test **/
    public function itCanTransitionFromInactiveToActive()
    {
        $user = User::factory()->inactive()->create();

        UpdateUserStatus::run($user, Active::class);

        $this->assertInstanceOf(Active::class, $user->status);
    }

    /** @test **/
    public function itThrowsAnExceptionIfTheUserCannotBeTransitionedToTheStatus()
    {
        $this->expectException(TransitionNotFound::class);

        UpdateUserStatus::run($this->user, Pending::class);

        $this->assertNotEquals(Pending::class, $this->user->status);
    }
}
