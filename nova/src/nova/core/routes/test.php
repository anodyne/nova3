<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$char = Character::find(1);

		s($char->user);
	});

	Route::get('partial', function()
	{
		echo partial('common/label', ['class' => 'label-info', 'value' => lang('short.create', lang('form'))]);
	});
});