<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\AssignCharacterOwners;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group characters
 * @group users
 */
class AssignCharacterOwnersActionTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->active()->create();
    }

    /** @test **/
    public function itAssignsOneUserToACharacterWithoutAnyUsers()
    {
        $first = User::factory()->active()->create();

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(1, $character->users);
        $this->assertCount(0, $character->activePrimaryUsers);
        $this->assertTrue($character->users->first()->is($first));
    }

    /** @test **/
    public function itAssignsOneUserToACharacterWithoutAnyUsersAndSetsTheCharacterAsThePrimaryCharacterForThatUser()
    {
        $first = User::factory()->active()->create();

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id],
            'primaryCharacters' => [$first->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(1, $character->users);
        $this->assertCount(1, $character->activePrimaryUsers);
        $this->assertTrue($character->users->first()->is($first));
        $this->assertTrue($character->activePrimaryUsers->first()->is($first));
    }

    /** @test **/
    public function itAssignsMultipleUsersToACharacterWithoutAnyUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $second->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(2, $character->users);
        $this->assertCount(0, $character->activePrimaryUsers);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertTrue($second->characters->first()->is($character));
    }

    /** @test **/
    public function itAssignsMultipleUsersToACharacterWithoutAnyUsersAndSetsItAsThePrimaryCharacterForOneOfTheUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $second->id],
            'primaryCharacters' => [$second->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(2, $character->users);
        $this->assertCount(1, $character->activePrimaryUsers);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertTrue($second->characters->first()->is($character));
        $this->assertFalse($character->activePrimaryUsers->first()->is($first));
        $this->assertTrue($character->activePrimaryUsers->first()->is($second));
    }

    /** @test **/
    public function itAssignsMultipleUsersToACharacterWithoutAnyUsersAndSetsItAsThePrimaryCharacterForAllUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $second->id],
            'primaryCharacters' => [$first->id, $second->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(2, $character->users);
        $this->assertCount(2, $character->activePrimaryUsers);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertTrue($second->characters->first()->is($character));
        $this->assertTrue($character->activePrimaryUsers->first()->is($first));
        $this->assertTrue($character->activePrimaryUsers->last()->is($second));
    }

    /** @test **/
    public function itAddsAUserToACharacterWithMultipleUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first);
        $this->character->users()->attach($second);

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $second->id, $third->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(3, $character->users);
        $this->assertCount(0, $character->activePrimaryUsers);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertTrue($second->characters->first()->is($character));
        $this->assertTrue($third->characters->first()->is($character));
    }

    /** @test **/
    public function itUpdatesTheUsersOnACharacterWithExistingUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first);
        $this->character->users()->attach($second);

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $third->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(2, $character->users);
        $this->assertCount(0, $character->activePrimaryUsers);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertNull($second->characters->first());
        $this->assertTrue($third->characters->first()->is($character));
    }

    /** @test **/
    public function itUpdatesTheUsersOnACharacterWithExistingUsersAndRemovesTheUserWithThePrimaryCharacter()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first, ['primary' => true]);
        $this->character->users()->attach($second);
        $this->character->refresh();

        $this->assertCount(1, $this->character->activePrimaryUsers);

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $third->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(2, $character->users);
        $this->assertCount(0, $character->activePrimaryUsers);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertNull($second->characters->first());
        $this->assertTrue($third->characters->first()->is($character));
    }

    /** @test **/
    public function itUpdatesThePrimaryUserForACharacter()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $this->character->users()->attach($first, ['primary' => true]);
        $this->character->users()->attach($second);
        $this->character->refresh();

        $this->assertCount(2, $this->character->users);
        $this->assertCount(1, $this->character->activePrimaryUsers);
        $this->assertTrue($this->character->activePrimaryUsers->first()->is($first));
        $this->assertFalse($this->character->activePrimaryUsers->first()->is($second));

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $second->id],
            'primaryCharacters' => [$second->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(2, $character->users);
        $this->assertCount(1, $character->activePrimaryUsers);
        $this->assertFalse($this->character->activePrimaryUsers->first()->is($first));
        $this->assertTrue($this->character->activePrimaryUsers->first()->is($second));
    }

    /** @test **/
    public function itUpdatesTheUsersForACharacterWhileChangingThePrimaryUserForACharacter()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first, ['primary' => true]);
        $this->character->users()->attach($second);
        $this->character->refresh();

        $this->assertCount(2, $this->character->users);
        $this->assertCount(1, $this->character->activePrimaryUsers);
        $this->assertTrue($this->character->activePrimaryUsers->first()->is($first));
        $this->assertFalse($this->character->activePrimaryUsers->first()->is($second));

        $data = AssignCharacterOwnersData::from([
            'users' => [$second->id, $third->id],
            'primaryCharacters' => [$third->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(2, $character->users);
        $this->assertCount(1, $character->activePrimaryUsers);
        $this->assertNull($first->characters->first());
        $this->assertTrue($second->characters->first()->is($character));
        $this->assertTrue($third->characters->first()->is($character));
        $this->assertFalse($this->character->activePrimaryUsers->first()->is($second));
        $this->assertTrue($this->character->activePrimaryUsers->first()->is($third));
    }

    /** @test **/
    public function itProperlyUpdatesThePrimaryCharacterOfAUser()
    {
        $user = User::factory()->active()->create();

        $oldPrimaryCharacter = Character::factory()->active()->create();
        $oldPrimaryCharacter->users()->attach($user, ['primary' => true]);
        $oldPrimaryCharacter->refresh();

        $this->assertTrue($oldPrimaryCharacter->activePrimaryUsers->first()->is($user));

        $data = AssignCharacterOwnersData::from([
            'users' => [$user->id],
            'primaryCharacters' => [$user->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $oldPrimaryCharacter->refresh();

        $this->assertCount(1, $character->users);
        $this->assertCount(1, $character->activePrimaryUsers);
        $this->assertCount(1, $oldPrimaryCharacter->users);
        $this->assertCount(0, $oldPrimaryCharacter->activePrimaryUsers);
        $this->assertTrue($character->users->first()->is($user));
        $this->assertTrue($character->activePrimaryUsers->first()->is($user));
        $this->assertTrue($oldPrimaryCharacter->users->first()->is($user));
    }

    /** @test **/
    public function itProperlyUpdatesThePrimaryCharacterOfMultipleUsers()
    {
        $first = User::factory()->active()->create();
        $firstOldPrimaryCharacter = Character::factory()->active()->create();
        $firstOldPrimaryCharacter->users()->attach($first, ['primary' => true]);

        $second = User::factory()->active()->create();
        $secondOldPrimaryCharacter = Character::factory()->active()->create();
        $secondOldPrimaryCharacter->users()->attach($second, ['primary' => true]);

        $data = AssignCharacterOwnersData::from([
            'users' => [$first->id, $second->id],
            'primaryCharacters' => [$first->id, $second->id],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $firstOldPrimaryCharacter->refresh();
        $secondOldPrimaryCharacter->refresh();

        $this->assertCount(2, $character->users);
        $this->assertCount(1, $character->users->where('id', $first->id));
        $this->assertCount(1, $character->users->where('id', $second->id));
        $this->assertCount(2, $character->activePrimaryUsers);
        $this->assertTrue((bool) $character->users[0]->pivot->primary);
        $this->assertTrue((bool) $character->users[1]->pivot->primary);

        $this->assertCount(1, $firstOldPrimaryCharacter->users);
        $this->assertCount(1, $firstOldPrimaryCharacter->users->where('id', $first->id));
        $this->assertCount(0, $firstOldPrimaryCharacter->activePrimaryUsers);
        $this->assertFalse((bool) $firstOldPrimaryCharacter->users[0]->pivot->primary);

        $this->assertCount(1, $secondOldPrimaryCharacter->users);
        $this->assertCount(1, $secondOldPrimaryCharacter->users->where('id', $second->id));
        $this->assertCount(0, $secondOldPrimaryCharacter->activePrimaryUsers);
        $this->assertFalse((bool) $secondOldPrimaryCharacter->users[0]->pivot->primary);
    }

    /** @test **/
    public function itCanAssignNoUsersToACharacter()
    {
        $data = AssignCharacterOwnersData::from([
            'users' => [],
        ]);

        $character = AssignCharacterOwners::run($this->character, $data);

        $this->assertCount(0, $character->users);
        $this->assertCount(0, $character->activePrimaryUsers);
    }
}
