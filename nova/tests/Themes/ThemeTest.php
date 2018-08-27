<?php

namespace Tests\Themes;

use Nova\Themes\Theme;
use Tests\DatabaseTestCase;
use Nova\Pages\Page;

class ThemeTest extends DatabaseTestCase
{
	protected $theme;

	public function setUp()
	{
		parent::setUp();

		$this->theme = factory(Theme::class)->create();
	}

	/**
	 * @test
	 * @covers Nova\Themes\Theme::getLayoutForPage
	 */
	public function it_can_get_the_layout_for_a_page()
	{
		//
	}

	/**
	 * @test
	 * @covers Nova\Themes\Theme::scopePath
	 */
	public function it_can_query_by_theme_path()
	{
		$themeByPath = Theme::path($this->theme->path)->first();

		$this->assertTrue($this->theme->is($themeByPath));
	}
}
