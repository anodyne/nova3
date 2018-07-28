<?php

namespace Nova\Authorize\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class RoleIndexResponse extends BaseResponsable
{
    public function views() : array
	{
		return [
			'page' => 'authorize.all-roles',
			'script' => 'authorize.all-roles',
		];
	}
}
