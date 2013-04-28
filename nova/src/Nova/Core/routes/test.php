<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		//Cache::put('nova.settings', Settings::getItems(false, false), 10);

		//s(Cache::get('nova.settings'));

		Cache::forget('nova.settings');

		return 'Done';
	});
});