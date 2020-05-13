<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThemesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanManageThemes()
    {
        $this->signInWithPermission('theme.create');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotManageThemes()
    {
        $this->signIn();

        $response = $this->get(route('themes.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotManageThemes()
    {
        $response = $this->get(route('themes.index'));
        $response->assertRedirect(route('login'));
    }
}
