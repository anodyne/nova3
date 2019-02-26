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

    public function setUp()
    {
        parent::setUp();

        $this->themeModel = factory(Theme::class)->create();

        $this->theme = (new class extends BaseTheme {});
        $this->theme->location = $this->themeModel->location;
    }

    public function testItCanAccessTheThemeModel()
    {
        $this->assertTrue($this->theme->getModel()->is($this->themeModel));
    }

    public function testAllOfItsIconMapsAreIdentical()
    {
        $this->assertEquals(
            count($this->theme->getFeatherIconMap()),
            count($this->theme->getFontAwesomeIconMap()),
            'Feather icon map and Font Awesome icon map do not match'
        );
    }
}
