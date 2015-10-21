<?php

$options = [
	'prefix'		=> 'setup',
	'namespace'		=> 'Nova\Setup\Http\Controllers'
];

Route::group($options, function()
{
	get('env', 'SetupController@environment')->name('setup.env');
	get('/', 'SetupController@index')->name('setup.home');
	get('update', 'UpdateController@index')->name('setup.update');
	post('uninstall', 'SetupController@uninstall')->name('setup.uninstall');
});

$installOptions = array_merge($options, [
	'prefix' => 'setup/install'
]);

Route::group($installOptions, function()
{
	get('/', 'InstallController@index')->name('setup.install');

	get('config-database', 'ConfigDbController@info')->name('setup.install.config.db');
	get('config-database/success', 'ConfigDbController@success')->name('setup.install.config.db.success');
	get('config-database/write', 'ConfigDbController@write')->name('setup.install.config.db.write');
	post('config-database/check', 'ConfigDbController@check')->name('setup.install.config.db.check');

	get('config-email', 'ConfigEmailController@info')->name('setup.install.config.email');
	get('config-email/success', 'ConfigEmailController@success')->name('setup.install.config.email.success');
	post('config-email/write', 'ConfigEmailController@write')->name('setup.install.config.email.write');

	get('nova', 'InstallController@installLanding')->name('setup.install.nova');
	get('nova/success', 'InstallController@novaSuccess')->name('setup.install.nova.success');
	post('nova', 'InstallController@install');

	get('user', 'InstallController@user')->name('setup.install.user');
	get('user/success', 'InstallController@userSuccess')->name('setup.install.user.success');
	post('user', 'InstallController@createUser')->name('setup.install.user.store');

	get('settings', 'InstallController@settings')->name('setup.install.settings');
	get('settings/success', 'InstallController@settingsSuccess')->name('setup.install.settings.success');
	post('settings', 'InstallController@updateSettings')->name('setup.install.settings.store');
});
