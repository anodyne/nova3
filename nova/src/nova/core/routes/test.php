<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('/', function()
	{
		$user = \User::find(1);
		$user->updateUserPreferences(['is_sysadmin' => (int) false]);

		s($user->getPreferenceItem('is_sysadmin'));
	});
});