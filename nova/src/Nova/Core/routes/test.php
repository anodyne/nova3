<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$user = User::find(13);
		$user->email = 'newemail@example.com';
		$user->save();

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