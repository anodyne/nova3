<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$user = User::find(1);

		s($user->appReviews);
	});
});