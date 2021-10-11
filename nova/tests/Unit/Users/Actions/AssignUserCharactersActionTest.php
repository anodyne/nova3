<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Characters\Models\States\Types\Support;
use Nova\Users\Actions\AssignUserCharacters;
use Nova\Users\DataTransferObjects\AssignUserCharactersData;
use Nova\Users\Models\User;
use Tests\TestCase;

class AssignUserCharactersActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(AssignUserCharacters::class);

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithoutAnyCharactersAndDoesNotSetThePrimaryCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();

        $data = new AssignUserCharactersData([
            'characters' => [$jackSparrow->id],
        ]);

        $user = $this->action->execute($this->user, $data);

        $jackSparrow->refresh();

        $this->assertCount(1, $user->characters);
        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertTrue($jackSparrow->type->equals(Secondary::class));
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithoutAnyCharactersAndSetsThePrimaryCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();

        $data = new AssignUserCharactersData([
            'characters' => [$jackSparrow->id],
            'primaryCharacter' => $jackSparrow,
        ]);

        $user = $this->action->execute($this->user, $data);

        $jackSparrow->refresh();

        $this->assertCount(1, $user->characters);
        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertTrue((bool) $user->primaryCharacter[0]->pivot->primary);
        $this->assertTrue($jackSparrow->type->equals(Primary::class));
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithExistingCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();

        $data = new AssignUserCharactersData([
            'characters' => [$jackSparrow->id, $willTurner->id],
            'primaryCharacter' => $jackSparrow,
        ]);

        $user = $this->action->execute($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();

        $this->assertCount(2, $user->characters);

        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertTrue((bool) $user->characters->where('id', $jackSparrow->id)->first()->pivot->primary);
        $this->assertTrue($jackSparrow->type->equals(Primary::class));

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertFalse((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertTrue($willTurner->type->equals(Secondary::class));
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithExistingCharacterAndChangesThePrimaryCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();

        $data = new AssignUserCharactersData([
            'characters' => [$jackSparrow->id, $willTurner->id],
            'primaryCharacter' => $willTurner,
        ]);

        $user = $this->action->execute($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();

        $this->assertCount(2, $user->characters);

        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertFalse((bool) $user->characters->where('id', $jackSparrow->id)->first()->pivot->primary);
        $this->assertTrue($jackSparrow->type->equals(Secondary::class));

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertTrue((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertTrue($willTurner->type->equals(Primary::class));
    }

    /** @test **/
    public function itRemovesAnAssignedCharacterFromAUser()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();

        $this->user->characters()->sync([$jackSparrow->id, $willTurner->id]);

        $data = new AssignUserCharactersData([
            'characters' => [$willTurner->id],
        ]);

        $user = $this->action->execute($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();

        $this->assertCount(1, $user->characters);

        $this->assertCount(0, $user->characters->where('id', $jackSparrow->id));
        $this->assertTrue($jackSparrow->type->equals(Support::class));

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertFalse((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertTrue($willTurner->type->equals(Secondary::class));
    }

    /** @test **/
    public function itAddsAndRemovesCharactersFromAUser()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();
        $elizabethSwann = Character::factory()->active()->create();

        $this->user->characters()->sync([$jackSparrow->id, $willTurner->id]);

        $data = new AssignUserCharactersData([
            'characters' => [$willTurner->id, $elizabethSwann->id],
            'primaryCharacter' => $elizabethSwann,
        ]);

        $user = $this->action->execute($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();
        $elizabethSwann->refresh();

        $this->assertCount(2, $user->characters);

        $this->assertCount(0, $user->characters->where('id', $jackSparrow->id));
        $this->assertTrue($jackSparrow->type->equals(Support::class));

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertFalse((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertTrue($willTurner->type->equals(Secondary::class));

        $this->assertCount(1, $user->characters->where('id', $elizabethSwann->id));
        $this->assertTrue((bool) $user->characters->where('id', $elizabethSwann->id)->first()->pivot->primary);
        $this->assertTrue($elizabethSwann->type->equals(Primary::class));
    }
}
