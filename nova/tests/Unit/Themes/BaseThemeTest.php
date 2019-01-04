<?php

namespace Tests\Unit\Themes;

use Tests\TestCase;
use Nova\Themes\BaseTheme;

class BaseThemeTest extends TestCase
{
    protected $theme;

    public function setUp()
    {
        parent::setUp();

        $this->theme = (new class extends BaseTheme {});
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
