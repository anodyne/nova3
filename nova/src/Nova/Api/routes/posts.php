<?php

Route::model('post', 'Post');

Route::group(array('prefix' => 'api/post'), function()
{
	Route::get('{post}', function(Post $post)
	{
		return $post;

		// probably should build this all manually so that we can control a few things
	});
});