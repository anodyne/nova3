<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Users\Actions\DeactivateUserCharacters;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;

/**
 * @group users
 * @group characters
 */
class DeactivateUserCharactersActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeactivateUserCharacters::class);

        $this->user = create(User::class, [], ['status:active']);

        $character1 = create(Character::class, [], ['status:active']);
        $character2 = create(Character::class, [], ['status:active']);
        $character3 = create(Character::class, [], ['status:active']);

        $this->user->characters()->attach($character1);
        $this->user->characters()->attach($character2);
        $this->user->characters()->attach($character3);
    }

    /** @test **/
    public function itDeactivatesAllCharactersForAUser()
    {
        $user = $this->action->execute($this->user);

        $this->assertCount(3, $user->characters->where('status', Inactive::class));
        $this->assertCount(0, $user->characters->where('status', Active::class));
    }
}
