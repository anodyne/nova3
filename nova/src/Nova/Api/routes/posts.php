<?php

Route::model('post', 'UserModel');

Route::group(array('prefix' => 'api/post'), function()
{
	Route::get('{post}', function(UserModel $post)
	{
		return $post;

		// probably should build this all manually so that we can control a few things
	});
});