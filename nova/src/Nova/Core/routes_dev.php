<?php

Route::group(array('prefix' => 'dev'), function()
{
	Route::get('/', function()
	{
		sd(User::searchCharacters('more')->get()->toArray());
	});
});