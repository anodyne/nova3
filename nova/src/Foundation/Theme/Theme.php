<?php

namespace Nova\Foundation\Theme;

use Nova\Themes\Theme as ThemeModel;
use Nova\Pages\Page;

class Theme
{
	use Icons, NavMain, NavSub, RendersTheme;

	public $path = 'pulsar';

	final public function __construct()
	{
		$this->initialize();
	}

	public function initialize() {}

	/**
	 * Get the model for this theme.
	 *
	 * @return \Nova\Themes\Theme
	 */
	public function getModel()
	{
		return ThemeModel::path($this->path)->firstOrFail();
	}

	/**
	 * Get the layout for a specific page.
	 *
	 * @param  \Nova\Pages\Page  $page
	 * @return string
	 */
	public function getPageLayout(Page $page)
	{
		return $this->getModel()->getLayoutForPage($page);
	}
}
