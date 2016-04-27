<?php

use Nova\Foundation\Services\Themes\Theme as BaseTheme;

class Theme extends BaseTheme {

	public function getIconMap()
	{
		return [
			'edit' => 'edit',
			'close' => 'remove_circle_outline',
			'delete' => 'delete',
			'notifications' => 'notifications',
		];
	}

}
