<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\AssignCharacterOwners;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;
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

    protected $action;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(AssignCharacterOwners::class);

        $this->character = Character::factory()->active()->create();
    }

    /** @test **/
    public function itAssignsOneUserToACharacterWithoutAnyUsers()
    {
        $first = User::factory()->active()->create();

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(1, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
    }

    /** @test **/
    public function itAssignsOneUserToACharacterWithoutAnyUsersAndSetsTheCharacterAsThePrimaryCharacterForThatUser()
    {
        $first = User::factory()->active()->create();

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id],
            'primaryCharacters' => [$first->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(1, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(1, $character->primaryUsers);
        $this->assertTrue((bool) $characterUsers[0]->pivot->primary);
    }

    /** @test **/
    public function itAssignsMultipleUsersToACharacterWithoutAnyUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id, $second->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(1, $characterUsers->where('id', $second->id));
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
        $this->assertFalse((bool) $characterUsers[1]->pivot->primary);
    }

    /** @test **/
    public function itAssignsMultipleUsersToACharacterWithoutAnyUsersAndSetsItAsThePrimaryCharacterForOneOfTheUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id, $second->id],
            'primaryCharacters' => [$second->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(1, $characterUsers->where('id', $second->id));
        $this->assertCount(1, $character->primaryUsers);
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
        $this->assertTrue((bool) $characterUsers[1]->pivot->primary);
    }

    /** @test **/
    public function itAssignsMultipleUsersToACharacterWithoutAnyUsersAndSetsItAsThePrimaryCharacterForAllUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id, $second->id],
            'primaryCharacters' => [$first->id, $second->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(1, $characterUsers->where('id', $second->id));
        $this->assertCount(2, $character->primaryUsers);
        $this->assertTrue((bool) $characterUsers[0]->pivot->primary);
        $this->assertTrue((bool) $characterUsers[1]->pivot->primary);
    }

    /** @test **/
    public function itAddsAUserToACharacterWithMultipleUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first);
        $this->character->users()->attach($second);

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id, $second->id, $third->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(3, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(1, $characterUsers->where('id', $second->id));
        $this->assertCount(1, $characterUsers->where('id', $third->id));
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
        $this->assertFalse((bool) $characterUsers[1]->pivot->primary);
        $this->assertFalse((bool) $characterUsers[2]->pivot->primary);
    }

    /** @test **/
    public function itUpdatesTheUsersOnACharacterWithExistingUsers()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first);
        $this->character->users()->attach($second);

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id, $third->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(0, $characterUsers->where('id', $second->id));
        $this->assertCount(1, $characterUsers->where('id', $third->id));
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
        $this->assertFalse((bool) $characterUsers[1]->pivot->primary);
    }

    /** @test **/
    public function itUpdatesTheUsersOnACharacterWithExistingUsersAndRemovesTheUserWithThePrimaryCharacter()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first, ['primary' => true]);
        $this->character->users()->attach($second);

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id, $third->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(0, $characterUsers->where('id', $second->id));
        $this->assertCount(1, $characterUsers->where('id', $third->id));
        $this->assertCount(0, $character->primaryUsers);
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
        $this->assertFalse((bool) $characterUsers[1]->pivot->primary);
    }

    /** @test **/
    public function itUpdatesThePrimaryUserForACharacter()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();

        $this->character->users()->attach($first, ['primary' => true]);
        $this->character->users()->attach($second);

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id, $second->id],
            'primaryCharacters' => [$second->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertCount(1, $characterUsers->where('id', $second->id));
        $this->assertCount(1, $character->primaryUsers);
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
        $this->assertTrue((bool) $characterUsers[1]->pivot->primary);
    }

    /** @test **/
    public function itUpdatesTheUsersForACharacterWhileChangingThePrimaryUserForACharacter()
    {
        $first = User::factory()->active()->create();
        $second = User::factory()->active()->create();
        $third = User::factory()->active()->create();

        $this->character->users()->attach($first, ['primary' => true]);
        $this->character->users()->attach($second);

        $data = new AssignCharacterOwnersData([
            'users' => [$second->id, $third->id],
            'primaryCharacters' => [$third->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(0, $characterUsers->where('id', $first->id));
        $this->assertCount(1, $characterUsers->where('id', $second->id));
        $this->assertCount(1, $characterUsers->where('id', $third->id));
        $this->assertCount(1, $character->primaryUsers);
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
        $this->assertTrue((bool) $characterUsers[1]->pivot->primary);
    }

    /** @test **/
    public function itProperlyUpdatesThePrimaryCharacterOfAUser()
    {
        $user = User::factory()->active()->create();

        $oldPrimaryCharacter = Character::factory()->active()->create();
        $oldPrimaryCharacter->users()->attach($user, ['primary' => true]);

        $data = new AssignCharacterOwnersData([
            'users' => [$user->id],
            'primaryCharacters' => [$user->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $oldPrimaryCharacter->refresh();

        $characterUsers = $character->users;

        $this->assertCount(1, $characterUsers);
        $this->assertCount(1, $oldPrimaryCharacter->users);
        $this->assertCount(1, $characterUsers->where('id', $user->id));
        $this->assertCount(1, $oldPrimaryCharacter->users->where('id', $user->id));
        $this->assertCount(1, $character->primaryUsers);
        $this->assertCount(0, $oldPrimaryCharacter->primaryUsers);
        $this->assertFalse((bool) $oldPrimaryCharacter->users[0]->pivot->primary);
        $this->assertTrue((bool) $characterUsers[0]->pivot->primary);
    }

    /** @test **/
    public function itProperlyUpdatesThePrimaryCharacterOfMultipleUsers()
    {
        $adam = User::factory()->active()->create();
        $adamOldPrimaryCharacter = Character::factory()->active()->create();
        $adamOldPrimaryCharacter->users()->attach($adam, ['primary' => true]);

        $ben = User::factory()->active()->create();
        $benOldPrimaryCharacter = Character::factory()->active()->create();
        $benOldPrimaryCharacter->users()->attach($ben, ['primary' => true]);

        $data = new AssignCharacterOwnersData([
            'users' => [$adam->id, $ben->id],
            'primaryCharacters' => [$adam->id, $ben->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $adamOldPrimaryCharacter->refresh();
        $benOldPrimaryCharacter->refresh();

        $characterUsers = $character->users;

        $this->assertCount(2, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $adam->id));
        $this->assertCount(1, $characterUsers->where('id', $ben->id));
        $this->assertCount(2, $character->primaryUsers);
        $this->assertTrue((bool) $characterUsers[0]->pivot->primary);
        $this->assertTrue((bool) $characterUsers[1]->pivot->primary);

        $this->assertCount(1, $adamOldPrimaryCharacter->users);
        $this->assertCount(1, $adamOldPrimaryCharacter->users->where('id', $adam->id));
        $this->assertCount(0, $adamOldPrimaryCharacter->primaryUsers);
        $this->assertFalse((bool) $adamOldPrimaryCharacter->users[0]->pivot->primary);

        $this->assertCount(1, $benOldPrimaryCharacter->users);
        $this->assertCount(1, $benOldPrimaryCharacter->users->where('id', $ben->id));
        $this->assertCount(0, $benOldPrimaryCharacter->primaryUsers);
        $this->assertFalse((bool) $benOldPrimaryCharacter->users[0]->pivot->primary);
    }
}
