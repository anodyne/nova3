<?php

namespace Tests\Unit\Themes;

use Tests\TestCase;
use Nova\Themes\BaseTheme;
use Nova\Themes\Models\Theme;
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

        $this->theme = (new class extends BaseTheme {
        });
        $this->theme->location = $this->themeModel->location;
    }

    /**
     * @test
     */
    public function itCanAccessTheThemeModel()
    {
        $this->assertTrue($this->theme->getModel()->is($this->themeModel));
    }

    /**
     * @test
     */
    public function allIconMapsAreTheSameLength()
    {
        $this->assertEquals(
            count($this->theme->getFeatherIconMap()),
            count($this->theme->getFontAwesomeIconMap()),
            'Feather icon map and Font Awesome icon map do not match'
        );
    }
}
