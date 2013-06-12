<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		Cache::forget('nova.content.message.login');
	});

	Route::get('partial', function()
	{
		echo partial('common/label', ['class' => 'label-info', 'value' => lang('short.create', lang('form'))]);
	});
});