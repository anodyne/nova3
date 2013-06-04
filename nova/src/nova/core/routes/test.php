<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$role = AccessRole::find(6);
		$task = AccessTask::find(1);

		//s($role->tasks->toArray());
		//s($task->roles);
		s(ucfirst(lang('short.alert.success.delete', langConcat('form tab'))));
	});

	Route::get('partial', function()
	{
		echo partial('common/label', ['class' => 'label-info', 'value' => lang('short.create', lang('form'))]);
	});
});