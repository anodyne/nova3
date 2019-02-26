<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemeProvidesFrontendDataTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp()
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    public function testTheThemeLocationIsAvailableToTheFrontend()
    {
        // $this->assertEquals(
        //     $this->theme->location,
        //     $this->app['nova.data.frontend']->get('location'),
        //     'The location available to the frontend does not match the backend'
        // );

        $this->markTestIncomplete();
    }

    public function testTheThemeIconSetIsAvailableToTheFrontend()
    {
        // $this->assertEquals(
        //     $this->theme->iconSet,
        //     $this->app['nova.data.frontend']->get('theme')->iconSet,
        //     'The icon set available to the frontend does not match the backend'
        // );

        $this->markTestIncomplete();
    }
}
