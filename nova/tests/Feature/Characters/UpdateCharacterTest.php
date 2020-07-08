<?php

namespace Tests\Feature\Characters;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Characters\Events\CharacterUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Requests\UpdateCharacterRequest;

/**
 * @group characters
 */
class UpdateCharacterTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = create(Character::class, [], ['status:active']);

        $position = create(Position::class);
        $user = create(User::class, [], ['status:active']);

        $this->character->positions()->attach($position);
        $this->character->users()->attach($user);
    }

    /** @test **/
    public function authorizedUserCanViewTheEditCharacterPage()
    {
        $this->signInWithPermission('character.update');

        $response = $this->get(route('characters.edit', $this->character));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateACharacter()
    {
        $this->signInWithPermission('character.update');

        $this->followingRedirects();

        $response = $this->put(route('characters.update', $this->character), [
            'name' => 'Jack Sparrow',
            'positions' => $this->character->positions->implode('id', ','),
            'users' => $this->character->users->implode('id', ','),
        ]);
        $response->assertSuccessful();

        $character = Character::latest()->first();

        $this->assertDatabaseHas('characters', [
            'id' => $this->character->id,
            'name' => 'Jack Sparrow',
        ]);

        $this->assertDatabaseHas('character_position', [
            'character_id' => $character->id,
            'position_id' => $this->character->positions->first()->id,
        ]);

        $this->assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => $this->character->users->first()->id,
        ]);

        $this->assertRouteUsesFormRequest(
            'characters.update',
            UpdateCharacterRequest::class
        );
    }

    /** @test **/
    public function eventsAreDispatchedWhenACharacterIsUpdated()
    {
        Event::fake();

        $this->withoutExceptionHandling();

        $this->signInWithPermission('character.update');

        dd($this->character->type);

        $response = $this->put(route('characters.update', $this->character), [
            'name' => 'Jack Sparrow',
            'positions' => $this->character->positions->implode('id', ','),
            'users' => $this->character->users->implode('id', ','),
        ]);

        Event::assertDispatched(CharacterUpdated::class);

        Event::assertDispatched(CharacterUpdatedByAdmin::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditCharacterPage()
    {
        $this->signIn();

        $response = $this->get(route('characters.edit', $this->character));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateACharacter()
    {
        $this->signIn();

        $this->followingRedirects();

        $response = $this->put(route('characters.update', $this->character), [
            'name' => 'Jack Sparrow',
            'positions' => '1',
        ]);
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditCharacterPage()
    {
        $response = $this->getJson(route('characters.edit', $this->character));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateACharacter()
    {
        $response = $this->putJson(route('characters.update', $this->character), [
            'name' => 'Jack Sparrow',
            'positions' => '1',
        ]);
        $response->assertUnauthorized();
    }
}
