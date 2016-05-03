<?php namespace Nova\Foundation;

use Status;

class Nova {

	public function javascriptValues()
	{
		// Grab the user so we can manually build the user object
		$currentUser = user();

		// Nova's system variables
		$system = ['system' => [
			'version' => config('nova.app.version.full'),
			'baseUrl' => app('request')->root(),
			'token' => csrf_token(),
			'genre' => config('nova.genre'),
		]];

		if ($currentUser)
		{
			$user = ['user' => [
				'name' => $user->present()->name,
				'nickname' => $user->nickname,
				'realName' => $user->name,
				'email' => $user->email,
				'status' => Status::toString($user->status),
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
		$data = ['data' => (array) app('nova.controller')->jsData];

		return array_merge($system, $user, $api, $data);
	}

}
