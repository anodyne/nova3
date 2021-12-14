<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 */
class DeactivateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itDeactivatesAUser()
    {
        $user = DeactivateUser::run($this->user);

        $this->assertInstanceOf(Inactive::class, $user->status);
    }
}
