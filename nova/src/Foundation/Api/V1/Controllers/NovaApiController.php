<?php namespace Nova\Foundation\Api\V1\Controllers;

class NovaApiController extends ApiBaseController {

	public function info()
	{
		return $this->response->array([
			'url'			=> app('request')->root(),
			'version_api'	=> 'v1',
			'version_nova'	=> config('nova.app.version.full'),
		]);
	}

}
