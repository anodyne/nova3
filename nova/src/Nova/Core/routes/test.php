<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$position = Position::find(1);

		s($position->dept->id);
	});
});