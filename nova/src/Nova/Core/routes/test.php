<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		//s(Config::get('cache'));
		//Cache::put('test', 'foo', 5);
		//s(Cache::get('test'));

		$foo = [];
		s($foo);

		return 'Done';
	});

	Route::get('sessions', function()
	{
		$user = User::find(1);

		s($user->last_login);
		s($user->updated_at);
		s($user->role->updated_at);
		
		s($user->last_login->diffInMinutes($user->role->updated_at, false));
		s($user->updated_at->diffInMinutes($user->role->updated_at, false));

		return 'Done';
	});
});