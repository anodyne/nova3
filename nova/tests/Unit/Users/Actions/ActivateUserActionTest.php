<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\ActivateUser;
use Nova\Users\Models\States\Active;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group users
 */
class ActivateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(ActivateUser::class);

        $this->user = create(User::class, [], ['status:inactive']);
    }

    /** @test **/
    public function itActivatesAUser()
    {
        $user = $this->action->execute($this->user);

        $this->assertTrue($user->status->equals(Active::class));
    }
}
