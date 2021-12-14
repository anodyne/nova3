<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Users\Actions\ActivateUser;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 */
class ActivateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->inactive()->create();
    }

    /** @test **/
    public function itActivatesAUser()
    {
        $user = ActivateUser::run($this->user);

        $this->assertInstanceOf(Active::class, $user->status);
    }
}
