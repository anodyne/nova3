<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('/', function()
	{
		//Cache::forget('nova.content.header.role');
		s(Cache::get('nova.content.header.admin'));
	});
});