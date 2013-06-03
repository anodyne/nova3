<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$role = AccessRole::find(6);
		$task = AccessTask::find(1);

		s($role->tasks->toArray());
		s($task->roles);
	});
});