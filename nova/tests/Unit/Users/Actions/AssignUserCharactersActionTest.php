<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Actions\AssignUserCharacters;
use Nova\Users\Data\AssignUserCharactersData;
use Nova\Users\Models\User;
use Tests\TestCase;

class AssignUserCharactersActionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithoutAnyCharactersAndDoesNotSetThePrimaryCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();

        $data = AssignUserCharactersData::from([
            'characters' => [$jackSparrow->id],
        ]);

        $user = AssignUserCharacters::run($this->user, $data);

        $jackSparrow->refresh();

        $this->assertCount(1, $user->characters);
        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertEquals(CharacterType::secondary, $jackSparrow->type);
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithoutAnyCharactersAndSetsThePrimaryCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();

        $data = AssignUserCharactersData::from([
            'characters' => [$jackSparrow->id],
            'primaryCharacter' => $jackSparrow,
        ]);

        $user = AssignUserCharacters::run($this->user, $data);

        $jackSparrow->refresh();

        $this->assertCount(1, $user->characters);
        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertTrue((bool) $user->primaryCharacter[0]->pivot->primary);
        $this->assertEquals(CharacterType::primary, $jackSparrow->type);
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithExistingCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();

        $data = AssignUserCharactersData::from([
            'characters' => [$jackSparrow->id, $willTurner->id],
            'primaryCharacter' => $jackSparrow,
        ]);

        $user = AssignUserCharacters::run($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();

        $this->assertCount(2, $user->characters);

        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertTrue((bool) $user->characters->where('id', $jackSparrow->id)->first()->pivot->primary);
        $this->assertEquals(CharacterType::primary, $jackSparrow->type);

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertFalse((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertEquals(CharacterType::secondary, $willTurner->type);
    }

    /** @test **/
    public function itAssignsACharacterToAUserWithExistingCharacterAndChangesThePrimaryCharacter()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();

        $data = AssignUserCharactersData::from([
            'characters' => [$jackSparrow->id, $willTurner->id],
            'primaryCharacter' => $willTurner,
        ]);

        $user = AssignUserCharacters::run($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();

        $this->assertCount(2, $user->characters);

        $this->assertCount(1, $user->characters->where('id', $jackSparrow->id));
        $this->assertFalse((bool) $user->characters->where('id', $jackSparrow->id)->first()->pivot->primary);
        $this->assertEquals(CharacterType::secondary, $jackSparrow->type);

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertTrue((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertEquals(CharacterType::primary, $willTurner->type);
    }

    /** @test **/
    public function itRemovesAnAssignedCharacterFromAUser()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();

        $this->user->characters()->sync([$jackSparrow->id, $willTurner->id]);

        $data = AssignUserCharactersData::from([
            'characters' => [$willTurner->id],
        ]);

        $user = AssignUserCharacters::run($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();

        $this->assertCount(1, $user->characters);

        $this->assertCount(0, $user->characters->where('id', $jackSparrow->id));
        $this->assertEquals(CharacterType::support, $jackSparrow->type);

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertFalse((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertEquals(CharacterType::secondary, $willTurner->type);
    }

    /** @test **/
    public function itAddsAndRemovesCharactersFromAUser()
    {
        $jackSparrow = Character::factory()->active()->create();
        $willTurner = Character::factory()->active()->create();
        $elizabethSwann = Character::factory()->active()->create();

        $this->user->characters()->sync([$jackSparrow->id, $willTurner->id]);

        $data = AssignUserCharactersData::from([
            'characters' => [$willTurner->id, $elizabethSwann->id],
            'primaryCharacter' => $elizabethSwann,
        ]);

        $user = AssignUserCharacters::run($this->user, $data);

        $jackSparrow->refresh();
        $willTurner->refresh();
        $elizabethSwann->refresh();

        $this->assertCount(2, $user->characters);

        $this->assertCount(0, $user->characters->where('id', $jackSparrow->id));
        $this->assertEquals(CharacterType::support, $jackSparrow->type);

        $this->assertCount(1, $user->characters->where('id', $willTurner->id));
        $this->assertFalse((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary);
        $this->assertEquals(CharacterType::secondary, $willTurner->type);

        $this->assertCount(1, $user->characters->where('id', $elizabethSwann->id));
        $this->assertTrue((bool) $user->characters->where('id', $elizabethSwann->id)->first()->pivot->primary);
        $this->assertEquals(CharacterType::primary, $elizabethSwann->type);
    }
}
