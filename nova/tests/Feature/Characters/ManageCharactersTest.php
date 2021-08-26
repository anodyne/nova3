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
