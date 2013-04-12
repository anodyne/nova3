<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('/', function()
	{
		$post = Post::find(1);
		$comment = Comment::find(12);

		s($comment->commentable);

		//$post->comments()->create(array('content' => 'Post comment'));

		//return 'Done';
	});
});