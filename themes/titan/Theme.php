<?php

use Nova\Foundation\Theme\Theme as BaseTheme;

class Theme extends BaseTheme
{
	public $path = 'titan';
	public $spriteMap = false;

	public function getIcon($iconKey, $additionalClasses = null)
	{
		$classes = implode(' ', array_merge([], [$additionalClasses]));

		return view("icons.{$iconKey}", compact('classes'))->render();

		try {

		} catch (\Exception $ex) {
			// return parent::getIcon($iconKey, $additionalClasses);
		}
	}
}
