<?php

declare(strict_types=1);

namespace Tests\Feature\Characters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Characters\Models\States\Types\Support;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;
use Tests\TestCase;

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
        $user = User::factory()->active()->create();
        $character = Character::factory()->active()->create();
        $character->users()->attach($user);

        Character::factory()->create();

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
        $user = User::factory()->active()->create();
        $character = Character::factory()->active()->create();
        $character->users()->attach($user);

        Character::factory()->create();

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
        $position = Position::factory()->create();
        $character = Character::factory()->create();
        $character->positions()->attach($position);

        Character::factory()->create();

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

        Character::factory()->active()->create([
            'name' => 'Sparrow Capitan',
        ]);

        Character::factory()->active()->create();

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

        $user = User::factory()->active()->create([
            'name' => 'Johnny Depp',
        ]);

        $character = Character::factory()->active()->create([
            'name' => 'Jack Sparrow',
        ]);
        $character->users()->attach($user);

        Character::factory()->active()->create();

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

        $user = User::factory()->active()->create([
            'email' => 'john@example.com',
        ]);

        $character = Character::factory()->active()->create([
            'name' => 'Jack Sparrow',
        ]);
        $character->users()->attach($user);

        Character::factory()->active()->create();

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

        $position = Position::factory()->create([
            'name' => 'Commanding Officer',
        ]);

        $character = Character::factory()->active()->create([
            'name' => 'Jack Sparrow',
        ]);
        $character->positions()->attach($position);

        Character::factory()->active()->create();

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

        $command = Department::factory()->create(['name' => 'Command']);
        $ops = Department::factory()->create(['name' => 'Operations']);

        $xoPosition = Position::factory()->create([
            'name' => 'Executive Officer',
            'department_id' => $command,
        ]);

        $xo2Position = Position::factory()->create([
            'name' => 'Second Officer',
            'department_id' => $command,
        ]);

        $opsPosition = Position::factory()->create([
            'name' => 'Chief Operations Officer',
            'department_id' => $ops,
        ]);

        $jack = Character::factory()->active()->create([
            'name' => 'Jack Sparrow',
        ]);
        $jack->positions()->attach($xoPosition);

        $will = Character::factory()->active()->create([
            'name' => 'Will Turner',
        ]);
        $will->positions()->attach($opsPosition);
        $will->positions()->attach($xo2Position);

        Character::factory()->active()->create();

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());

        $response = $this->get(route('characters.index', 'search=command'));
        $response->assertSuccessful();

        $this->assertCount(2, $response['characters']);
    }
}
