<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThemesTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorizedUserCanManageThemes()
    {
        $this->signInWithAbility('theme.create');

        $this->get(route('themes.index'))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotManageThemes()
    {
        $this->signIn();

        $this->get(route('themes.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotManageThemes()
    {
        $this->get(route('themes.index'))
            ->assertRedirect(route('login'));
    }
}
