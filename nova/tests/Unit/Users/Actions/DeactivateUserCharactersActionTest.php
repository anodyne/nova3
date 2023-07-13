<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 * @group characters
 */
class DeactivateUserCharactersActionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();

        $character1 = Character::factory()->active()->create();
        $character2 = Character::factory()->active()->create();
        $character3 = Character::factory()->active()->create();

        $this->user->characters()->attach($character1);
        $this->user->characters()->attach($character2);
        $this->user->characters()->attach($character3);
    }

    /** @test **/
    public function itDeactivatesAllCharactersForAUser()
    {
        $user = DeactivateUser::run($this->user);

        $this->assertCount(3, $user->characters->where('status', Inactive::$name));
        $this->assertCount(0, $user->characters->where('status', Active::$name));
    }
}
