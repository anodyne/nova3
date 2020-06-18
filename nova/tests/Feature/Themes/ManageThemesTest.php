<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class ManageThemesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.create');

        $this->withoutExceptionHandling();

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.update');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.delete');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.view');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageThemesPage()
    {
        $this->signIn();

        $response = $this->get(route('themes.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageThemesPage()
    {
        $response = $this->getJson(route('themes.index'));
        $response->assertUnauthorized();
    }
}
