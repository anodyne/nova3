<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		//s(Config::get('cache'));
		//Cache::put('test', 'foo', 5);
		s(Cache::get('test'));

		return 'Done';
	});
});