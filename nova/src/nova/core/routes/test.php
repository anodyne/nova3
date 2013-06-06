<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		//Cache::forever('nova.settings', Settings::get()->toSimpleObject('key', 'value'));

		s(Cache::get('nova.routes'));
		s(Cache::get('nova.settings'));
		//s(Settings::get()->toSimpleObject('key', 'value'));
	});

	Route::get('partial', function()
	{
		echo partial('common/label', ['class' => 'label-info', 'value' => lang('short.create', lang('form'))]);
	});
});