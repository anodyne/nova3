<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('/', function()
	{
		sd(User::searchCharacters('daniela')->get()->toArray());
	});
});