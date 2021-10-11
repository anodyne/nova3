<?php

declare(strict_types=1);

namespace Tests\Feature\Characters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterUpdated;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;
use Tests\TestCase;

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

        $this->character = Character::factory()->create();

        $position = Position::factory()->create();
        $user = User::factory()->create();

        $this->character->positions()->attach($position);
        $this->character->users()->attach($user);

        $this->character->refresh();
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

        $rank = RankItem::factory()->create();

        $response = $this->put(route('characters.update', $this->character), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
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

        $this->signInWithPermission('character.update');

        $rank = RankItem::factory()->create();

        $response = $this->put(route('characters.update', $this->character), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
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
