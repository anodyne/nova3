<?php namespace Nova\Foundation;

use Status;

class Nova {

	public function javascriptValues()
	{
		// Grab the user so we can manually build the user object
		$user = user();

		// Nova's global variables
		$global = ['global' => [
			'version' => config('nova.app.version.full'),
			'baseUrl' => app('request')->root(),
			'token' => csrf_token(),
			'genre' => config('nova.genre'),
		]];

		if ($user)
		{
			$global['user'] = [
				'name' => $user->present()->name,
				'nickname' => $user->nickname,
				'realName' => $user->name,
				'email' => $user->email,
				'status' => Status::toString($user->status),
			];
		}
		else
		{
			$global['user'] = [
				'name' => null,
				'nickname' => null,
				'realName' => null,
				'email' => null,
				'status' => null,
			];
		}

		// Nova's API options
		$api = ['api' => config('nova.api')];

		// Nova's controller data
		$data = ['data' => (array) app('nova.controller')->jsData];

		return array_merge($global, $api, $data);
	}

}
