<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$forms = NovaForm::orderAsc('name')->get();
		s($forms->toSimpleArray());

		$forms = NovaForm::orderDesc('name')->get();
		s($forms->toSimpleArray());
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

	Route::get('forms', function()
	{
		//NovaFormSection::create(['form_id' => 3, 'name' => 'foo']);
		//Cache::forget('nova.installed');
	});
});