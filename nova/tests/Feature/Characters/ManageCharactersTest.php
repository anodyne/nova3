<?php

declare(strict_types=1);

namespace Tests\Feature\Characters;

use Nova\Characters\Models\Character;
use Tests\TestCase;

/**
 * @group characters
 */
class ManageCharactersTest extends TestCase
{
    /** @test **/
    public function authorizedUserCanSeeAllCharactersOnManageCharactersPage()
    {
        $this->signInWithPermission('character.create');

        Character::factory()->count(10)->create();

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertCount(10, $response['characters']);
    }

    /** @test **/
    public function unauthorizedUserCanOnlySeeTheirOwnCharactersOnManageCharactersPage()
    {
        $this->signIn();

        Character::factory()->count(8)->create();
        Character::factory()->count(2)->hasAttached(auth()->user())->create();

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();

        $this->assertCount(2, $response['characters']);
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageCharactersPage()
    {
        $response = $this->getJson(route('characters.index'));
        $response->assertUnauthorized();
    }
}
