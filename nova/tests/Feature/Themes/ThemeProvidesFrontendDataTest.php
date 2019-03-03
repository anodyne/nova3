<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemeProvidesFrontendDataTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    /** @test **/
    public function the_theme_location_is_available_to_the_frontend()
    {
        // $this->assertEquals(
        //     $this->theme->location,
        //     $this->app['nova.data.frontend']->get('location'),
        //     'The location available to the frontend does not match the backend'
        // );

        $this->markTestIncomplete();
    }

    /** @test **/
    public function the_theme_icon_set_is_available_to_the_frontend()
    {
        // $this->assertEquals(
        //     $this->theme->iconSet,
        //     $this->app['nova.data.frontend']->get('theme')->iconSet,
        //     'The icon set available to the frontend does not match the backend'
        // );

        $this->markTestIncomplete();
    }
}
