<?php namespace Nova\Foundation;

use Status;

class Nova {

	public function javascriptValues()
	{
		// Grab the user so we can manually build the user object
		$user = user();

		// Nova's global state
		$state = ['state' => [
			'version' => config('nova.app.version.full'),
			'baseUrl' => app('request')->root(),
			'token' => csrf_token(),
			'genre' => config('nova.genre'),
			'user' => [
				'name' => $user->present()->name,
				'nickname' => $user->nickname,
				'realName' => $user->name,
				'email' => $user->email,
				'status' => Status::toString($user->status)
			]
		]];

		// Nova's API options
		$api = ['api' => config('nova.api')];

		// Nova's controller data
		$data = ['data' => (array) app('nova.controller')->jsData];

		return array_merge($state, $api, $data);
	}

}
