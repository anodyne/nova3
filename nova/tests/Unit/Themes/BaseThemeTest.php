<?php

namespace Tests\Unit\Themes;

use Tests\TestCase;
use Nova\Themes\Theme;
use Nova\Themes\BaseTheme;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;
    protected $themeModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->themeModel = factory(Theme::class)->create();

        $this->theme = (new class extends BaseTheme {});
        $this->theme->location = $this->themeModel->location;
    }

    /** @test **/
    public function it_can_access_the_theme_model()
    {
        $this->assertTrue($this->theme->getModel()->is($this->themeModel));
    }

    /** @test **/
    public function all_of_its_icon_maps_are_the_same_size()
    {
        $this->assertEquals(
            count($this->theme->getFeatherIconMap()),
            count($this->theme->getFontAwesomeIconMap()),
            'Feather icon map and Font Awesome icon map do not match'
        );
    }
}
