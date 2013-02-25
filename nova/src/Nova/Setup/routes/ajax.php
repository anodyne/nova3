<?php

Route::group(array('prefix' => 'setup/ajax', 'before' => 'configFileCheck|setupAuthorization'), function()
{
	Route::get('ignore_version', function()
	{
		// Update the system information table with the ignore version
		SystemModel::updateInfo(array(
			'version_ignore' => Input::post('version')
		));
	});
});