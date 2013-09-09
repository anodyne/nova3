<?php

Route::group(['prefix' => 'dev'], function()
{
	Route::get('/{string?}', function()
	{
		s(Cache::get('nova.content.header.manage'));
	});
});