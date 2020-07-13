<?php

namespace Tests\Feature\Characters;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Models\States\Statuses\Inactive;

/**
 * @group characters
 */
class FilterCharactersTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function manageCharactersPageCanShowAllCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());
    }

    /** @test **/
    public function charactersCanBeFilteredByActiveCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'status=active'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('status', Active::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredByPendingCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'status=pending'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('status', Pending::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredByInactiveCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'status=inactive'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('status', Inactive::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredToOnlyPrimaryCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'type=primary'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('type', Primary::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredToOnlySupportCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'type=support'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('type', Support::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredToOnlySecondaryCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'type=secondary'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('type', Secondary::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredToOnlyCharactersAssignedToUsers()
    {
        $user = create(User::class, [], ['status:active']);
        $character = create(Character::class, [], ['status:active']);
        $character->users()->attach($user);

        create(Character::class);

        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'hasuser=1'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereHas('users')->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredToOnlyCharactersNotAssignedToUsers()
    {
        $user = create(User::class, [], ['status:active']);
        $character = create(Character::class, [], ['status:active']);
        $character->users()->attach($user);

        create(Character::class);

        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'nouser=1'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereDoesntHave('users')->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredToOnlyCharactersWithoutAPositionAssignedToThem()
    {
        $position = create(Position::class);
        $character = create(Character::class);
        $character->positions()->attach($position);

        create(Character::class);

        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'noposition=1'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereDoesntHave('positions')->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function charactersCanBeFilteredByCharacterName()
    {
        $this->signInWithPermission('character.create');

        create(Character::class, [
            'name' => 'Sparrow Capitan',
        ], ['status:active']);

        create(Character::class, [], ['status:active']);

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());

        $response = $this->get(route('characters.index', 'search=sparrow'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['characters']);
    }

    /** @test **/
    public function charactersCanBeFilteredByAssignedUserName()
    {
        $this->signInWithPermission('character.create');

        $user = create(User::class, [
            'name' => 'Johnny Depp',
        ], ['status:active']);

        $character = create(Character::class, [
            'name' => 'Jack Sparrow',
        ], ['status:active']);
        $character->users()->attach($user);

        create(Character::class, [], ['status:active']);

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());

        $response = $this->get(route('characters.index', 'search=depp'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['characters']);
    }

    /** @test **/
    public function charactersCanBeFilteredByAssignedUserEmail()
    {
        $this->signInWithPermission('character.create');

        $user = create(User::class, [
            'email' => 'john@example.com',
        ], ['status:active']);

        $character = create(Character::class, [
            'name' => 'Jack Sparrow',
        ], ['status:active']);
        $character->users()->attach($user);

        create(Character::class, [], ['status:active']);

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());

        $response = $this->get(route('characters.index', 'search=john@example.com'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['characters']);
    }

    /** @test **/
    public function charactersCanBeFilteredByAssignedPositionName()
    {
        $this->signInWithPermission('character.create');

        $position = create(Position::class, [
            'name' => 'Commanding Officer',
        ]);

        $character = create(Character::class, [
            'name' => 'Jack Sparrow',
        ], ['status:active']);
        $character->positions()->attach($position);

        create(Character::class, [], ['status:active']);

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());

        $response = $this->get(route('characters.index', 'search=commanding'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['characters']);
    }

    /** @test **/
    public function charactersCanBeFilteredByAssignedDepartmentName()
    {
        $this->signInWithPermission('character.create');

        $command = create(Department::class, ['name' => 'Command']);
        $ops = create(Department::class, ['name' => 'Operations']);

        $xoPosition = create(Position::class, [
            'name' => 'Executive Officer',
            'department_id' => $command,
        ]);

        $xo2Position = create(Position::class, [
            'name' => 'Second Officer',
            'department_id' => $command,
        ]);

        $opsPosition = Create(Position::class, [
            'name' => 'Chief Operations Officer',
            'department_id' => $ops,
        ]);

        $jack = create(Character::class, [
            'name' => 'Jack Sparrow',
        ], ['status:active']);
        $jack->positions()->attach($xoPosition);

        $will = create(Character::class, [
            'name' => 'Will Turner',
        ], ['status:active']);
        $will->positions()->attach($opsPosition);
        $will->positions()->attach($xo2Position);

        create(Character::class, [], ['status:active']);

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());

        $response = $this->get(route('characters.index', 'search=command'));
        $response->assertSuccessful();

        $this->assertCount(2, $response['characters']);
    }
}
