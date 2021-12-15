<?php

declare(strict_types=1);

namespace Tests\Feature\Characters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group characters
 */
class ManageCharactersTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authenticatedUserCanViewManageCharactersPage()
    {
        $this->signIn();

        $response = $this->get(route('characters.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanSeeAllCharactersOnManageCharactersPage()
    {
        $this->signInWithPermission('character.create');

        $this->markTestIncomplete();
    }

    /** @test **/
    public function unauthorizedUserCanOnlySeeTheirOwnCharactersOnManageCharactersPage()
    {
        $this->signIn();

        $this->markTestIncomplete();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageCharactersPage()
    {
        $response = $this->getJson(route('characters.index'));
        $response->assertUnauthorized();
    }
}
