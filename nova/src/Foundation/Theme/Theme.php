<?php namespace Nova\Foundation\Theme;

class Theme
{
	use Icons, NavMain, NavSub, RendersTheme;

	public $path = 'pulsar';

	final public function __construct()
	{
		// Prepend the theme path to the view locations
		view()->getFinder()->prependLocation(theme_path($this->path));

		// Allow finding Javascript files
		view()->addExtension('js', 'file');

		$this->initialize();
	}

	public function initialize() {}
}
