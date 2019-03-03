<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThemesTest extends TestCase
{
    use RefreshDatabase;

<<<<<<< HEAD
    public function testAnAuthorizedUserCanViewTheManageThemesPage()
=======
    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    /** @test **/
    public function an_authorized_user_can_view_the_manage_themes_page()
>>>>>>> dev
    {
        $this->signIn();

        $this->get(route('themes.index'))
            ->assertSuccessful();
    }
}