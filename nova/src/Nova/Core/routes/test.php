<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$user = User::create([
			'name' => 'Dave Public',
			'email' => 'dave.public6@example.com',
			'password' => 'password',
			'foo' => 'bar'
		]);

		s($user);
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

	Route::get('uppercase', function()
	{
		s(lang('short.add', langConcat('user route')));
		s(lang('Short.add', langConcat('user Route')));
	});
});