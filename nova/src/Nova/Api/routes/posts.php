<?php

Route::model('post', 'User');

Route::group(array('prefix' => 'api/post'), function()
{
	Route::get('{post}', function(User $post)
	{
		return $post;

		// probably should build this all manually so that we can control a few things
	});
});