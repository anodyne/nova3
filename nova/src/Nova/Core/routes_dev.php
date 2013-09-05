<?php

Route::group(['prefix' => 'dev'], function()
{
	Route::get('/{string?}', function()
	{
		$a = Config::get('app.aliases');

		$form = App::make($a['FormRepositoryInterface']);

		s($form->findByKey('user'));
	});
});