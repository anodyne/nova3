<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		s(Config::get('mail'));
	});

	Route::get('partial', function()
	{
		echo partial('common/label', ['class' => 'label-info', 'value' => lang('short.create', lang('form'))]);
	});
});