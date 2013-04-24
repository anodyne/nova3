<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$char = new Character;
		$char->first_name = 'John';
		$char->last_name = 'Public';
		$char->activated = Date::now();
		$char->save();
	});
});