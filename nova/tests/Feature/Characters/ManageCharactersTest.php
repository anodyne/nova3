<?php

namespace Tests\Feature\Characters;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Npc;
use Nova\Characters\Models\States\Types\Pnpc;
use Nova\Characters\Models\States\Types\Primary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Models\States\Statuses\Inactive;

/**
 * @group characters
 */
class ManageCharactersTest extends TestCase
{
    use RefreshDatabase;

    protected $activeCharacter;

    protected $pendingCharacter;

    protected $inactiveCharacter;

    public function setUp(): void
    {
        parent::setUp();

        $this->activeCharacter = create(Character::class, [], ['status:active']);

        $this->pendingCharacter = create(Character::class, [], ['status:pending']);

        $this->inactiveCharacter = create(Character::class, [], ['status:inactive']);
    }

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageCharactersPage()
    {
        $this->signInWithPermission('character.create');

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageCharactersPage()
    {
        $this->signInWithPermission('character.update');

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageCharactersPage()
    {
        $this->signInWithPermission('character.delete');

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageCharactersPage()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function manageCharactersPageCanShowAllCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertEquals(Character::count(), $response['characters']->total());
    }

    /** @test **/
    public function manageCharactersPageCanShowOnlyActiveCharacters()
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
    public function manageCharactersPageCanShowOnlyPendingCharacters()
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
    public function manageCharactersPageCanShowOnlyInactiveCharacters()
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
    public function manageCharactersPageCanShowOnlyPrimaryCharacters()
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
    public function manageCharactersPageCanShowOnlyNpcCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'type=npc'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('type', Npc::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function manageCharactersPageCanShowOnlyProtectedNpcCharacters()
    {
        $this->signInWithPermission('character.view');

        $response = $this->get(route('characters.index', 'type=pnpc'));
        $response->assertSuccessful();

        $this->assertEquals(
            Character::whereState('type', Pnpc::class)->count(),
            $response['characters']->total()
        );
    }

    /** @test **/
    public function manageCharactersPageCanShowOnlyCharactersAssignedToUsers()
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
    public function manageCharactersPageCanShowOnlyCharactersNotAssignedToUsers()
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
    public function unauthorizedUserCannotViewManageCharactersPage()
    {
        $this->signIn();

        $response = $this->get(route('characters.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageCharactersPage()
    {
        $response = $this->getJson(route('characters.index'));
        $response->assertUnauthorized();
    }
}
