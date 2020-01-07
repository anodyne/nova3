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
        $this->signInWithAbility('theme.create');

        $this->get(route('themes.index'))
            ->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotManageThemes()
    {
        $this->signIn();

        $this->get(route('themes.index'))
            ->assertForbidden();
    }

    /** @test **/
    public function guestCannotManageThemes()
    {
        $this->get(route('themes.index'))
            ->assertRedirect(route('login'));
    }
}
