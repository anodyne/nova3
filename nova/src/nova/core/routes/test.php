<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('index', function()
	{
		$skin = SkinCatalog::find(1);

		$file = $skin->getQuickInstallFile('options.json');

		$search = array_filter($file->items, function($f)
		{
			return $f->key == 'banner_image';
		});

		sd(reset($search));
	});

	Route::get('partial', function()
	{
		echo partial('common/label', ['class' => 'label-info', 'value' => lang('short.create', lang('form'))]);
	});

	Route::get('forms', function()
	{
		echo DynamicForm::setup('character', 1, false)->build();
	});

	Route::get('email', function()
	{
		$users = User::active()->get();

		$final = $users->filter(function($u)
		{
			$emailPref = $u->getPreferenceItem('email_format');

			return ($emailPref == 'html');
		})->toSimpleArray('id', 'email');

		sd($final);
	});

	Route::get('location', function()
	{
		sd(Location::page('admin/form/forms'));
	});
});