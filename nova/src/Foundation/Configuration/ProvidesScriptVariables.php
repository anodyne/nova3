<?php namespace Nova\Foundation\Configuration;

use Status;

trait ProvidesScriptVariables {

	public function scriptVariables()
	{
		// Grab the user so we can manually build the user object
		$currentUser = user();

		// Nova's system variables
		$system = ['system' => [
			'version' => $this->version,
			'baseUrl' => app('request')->root(),
			'token' => csrf_token(),
			'genre' => config('nova.genre'),
		]];

		if ($currentUser)
		{
			$user = ['user' => [
				'name' => $currentUser->present()->name,
				'nickname' => $currentUser->nickname,
				'realName' => $currentUser->name,
				'email' => $currentUser->email,
				'status' => Status::toString($currentUser->status),
			]];
		}
		else
		{
			$user = ['user' => [
				'name' => null,
				'nickname' => null,
				'realName' => null,
				'email' => null,
				'status' => null,
			]];
		}

		// Nova's API options
		$api = ['api' => config('nova.api')];

		// Nova's controller data
		$data = ['data' => (array) app('nova.controller')->data];

		return array_merge($system, $user, $api, $data);
	}
}
