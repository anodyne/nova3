<?php namespace Nova\Api\V1\Controllers;

class NovaApiController extends ApiBaseController {

	public function info()
	{
		return $this->response->array([
			'url'			=> app('request')->root(),
			'version_api'	=> config('nova.api.version'),
			'version_nova'	=> config('nova.app.version.full'),
		]);
	}

}
