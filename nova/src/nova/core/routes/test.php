<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		s(NovaFormSection::find(7)->fields->toArray());
	});

	Route::get('partial', function()
	{
		echo partial('common/label', ['class' => 'label-info', 'value' => lang('short.create', lang('form'))]);
	});
});