<?php

namespace Tests\Feature\Characters;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Characters\Events\CharacterCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Events\CharacterCreatedByAdmin;
use Nova\Characters\Requests\CreateCharacterRequest;
use Nova\Ranks\Models\RankItem;

/**
 * @group characters
 */
class CreateCharacterTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreateCharacterPage()
    {
        $this->signInWithPermission('character.create');

        $response = $this->get(route('characters.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateACharacter()
    {
        $this->signInWithPermission('character.create');

        $position = create(Position::class);
        $rank = create(RankItem::class);
        $user = create(User::class, [], ['status:active']);

        $this->followingRedirects();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => $position->id,
            'users' => $user->id,
        ]);
        $response->assertSuccessful();

        $character = Character::latest()->first();

        $this->assertDatabaseHas('characters', [
            'name' => 'Jack Sparrow',
        ]);

        $this->assertDatabaseHas('character_position', [
            'character_id' => $character->id,
            'position_id' => $position->id,
        ]);

        $this->assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => $user->id,
        ]);

        $this->assertRouteUsesFormRequest(
            'characters.store',
            CreateCharacterRequest::class
        );
    }

    /** @test **/
    public function authorizedUserCanCreateACharacterAsAPrimaryCharacter()
    {
        $this->signInWithPermission('character.create');

        $position = create(Position::class);
        $rank = create(RankItem::class);
        $user = create(User::class, [], ['status:active']);

        $this->followingRedirects();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => $position->id,
            'users' => $user->id,
            'primary_character' => [$user->id],
        ]);
        $response->assertSuccessful();

        $character = Character::latest()->first();

        $this->assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => $user->id,
            'primary' => (int) true,
        ]);
    }

    /** @test **/
    public function eventsAreDispatchedWhenACharacterIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('character.create');

        $position = create(Position::class);
        $rank = create(RankItem::class);

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => $position->id,
        ]);

        Event::assertDispatched(CharacterCreated::class);

        Event::assertDispatched(CharacterCreatedByAdmin::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateCharacterPage()
    {
        $this->signIn();

        $response = $this->get(route('characters.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateACharacter()
    {
        $this->signIn();

        $this->followingRedirects();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'positions' => '1',
        ]);
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateCharacterPage()
    {
        $response = $this->getJson(route('characters.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateACharacter()
    {
        $response = $this->postJson(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'positions' => '1',
        ]);
        $response->assertUnauthorized();
    }
}
