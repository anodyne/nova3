<?php

namespace Nova\Themes;

class ThemeFactory
{
	public static function make($themePath)
	{
		$class = sprintf('\Themes\%s\Theme', ucfirst($themePath));

		if (class_exists($class)) {
			return new $class;
		}

		return new BaseTheme;
	}
}
