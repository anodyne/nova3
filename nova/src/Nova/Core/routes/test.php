<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		Cache::forget('content_title_role');
		Cache::forget('content_header_role');
		Cache::forget('content_message_role');
	});
});