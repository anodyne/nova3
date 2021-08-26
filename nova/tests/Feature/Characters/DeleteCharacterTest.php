<?php

declare(strict_types=1);

namespace Tests\Feature\Characters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterDeleted;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Models\Character;
use Tests\TestCase;

/**
 * @group characters
 */
class DeleteCharacterTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->active()->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteCharacter()
    {
        $this->signInWithPermission('character.delete');

        $this->followingRedirects();

        $response = $this->delete(route('characters.destroy', $this->character));
        $response->assertSuccessful();

        $this->assertSoftDeleted('characters', $this->character->only('id'));
    }

    /** @test **/
    public function eventsAreDispatchedWhenUserIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('character.delete');

        $this->delete(route('characters.destroy', $this->character));

        Event::assertDispatched(CharacterDeleted::class);
        Event::assertDispatched(CharacterDeletedByAdmin::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteCharacter()
    {
        $this->signIn();

        $response = $this->delete(route('characters.destroy', $this->character));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteCharacter()
    {
        $response = $this->deleteJson(route('characters.destroy', $this->character));
        $response->assertUnauthorized();
    }
}
