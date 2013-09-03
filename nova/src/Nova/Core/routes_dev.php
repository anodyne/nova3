<?php

Route::group(['prefix' => 'dev'], function()
{
	Route::get('/{string?}', function()
	{
		s(URL::full());
		s(URL::current());
		s(Request::root());
	});
});