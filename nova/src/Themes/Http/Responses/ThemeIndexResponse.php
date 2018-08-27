<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class ThemeIndexResponse extends BaseResponsable
{
	public function views() : array
	{
		return [
			'page' => 'themes.all-themes',
			'script' => 'themes.all-themes',
		];
	}
}
