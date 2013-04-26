<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$role = AccessRole::find(2);

		s($role->tasks->toArray());
		//s(DB::getQueryLog());

		//$role->tasks()->sync(array(2, 3, 6, 100, 200));

		//$role = AccessRole::find(2);

		//s($role->tasks->toSimpleArray());
	});

	Route::get('cookie1', function()
	{
		return Redirect::to('test/cookie2')->withCookie(Cookie::forget('test'));
	});
	Route::get('cookie2', function()
	{
		s(Cookie::get('test'));
	});
});