<?php

namespace Nova\Dashboard\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class DashboardResponse extends BaseResponsable
{
	public function views() : array
	{
		return [
			'page' => 'dashboard.dashboard',
			'script' => 'dashboard.dashboard',
		];
	}
}
