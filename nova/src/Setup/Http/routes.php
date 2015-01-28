<?php

$options = [
	'prefix'		=> 'setup',
	'namespace'		=> 'Nova\Setup\Http\Controllers'
];

Route::group($options, function()
{
	Route::get('env', [
		'as'	=> 'setup.env',
		'uses'	=> 'SetupController@environment']);

	Route::get('/', [
		'as'	=> 'setup.home',
		'uses'	=> 'SetupController@index']);

	Route::get('start', [
		'as'	=> 'setup.start',
		'uses'	=> 'SetupController@start']);

	Route::get('config/email', [
		'as'	=> 'setup.config.email',
		'uses'	=> 'EmailConfigController@index']);

	Route::get('update', [
		'as'	=> 'setup.update',
		'uses'	=> 'UpdateController@index']);
});

$installOptions = array_merge($options, [
	'prefix' => 'setup/install'
]);

Route::group($installOptions, function()
{
	Route::get('/', [
		'as'	=> 'setup.install',
		'uses'	=> 'InstallController@index']);

	Route::get('config-database', [
		'as'	=> 'setup.install.config.db',
		'uses'	=> 'ConfigDbController@info']);
	Route::get('config-database/success', [
		'as'	=> 'setup.install.config.db.success',
		'uses'	=> 'ConfigDbController@success']);
	Route::get('config-database/write', [
		'as'	=> 'setup.install.config.db.write',
		'uses'	=> 'ConfigDbController@write']);
	Route::post('config-database/check', [
		'as'	=> 'setup.install.config.db.check',
		'uses'	=> 'ConfigDbController@check']);

	Route::get('config-email', [
		'as'	=> 'setup.install.config.email',
		'uses'	=> 'ConfigEmailController@info']);
	Route::get('config-email/success', [
		'as'	=> 'setup.install.config.email.success',
		'uses'	=> 'ConfigEmailController@success']);
	Route::post('config-email/write', [
		'as'	=> 'setup.install.config.email.write',
		'uses'	=> 'ConfigEmailController@write']);

	Route::get('nova', [
		'as'	=> 'setup.install.nova',
		'uses'	=> 'InstallController@installLanding']);
	Route::post('nova', 'InstallController@install');
	Route::get('nova/success', [
		'as'	=> 'setup.install.nova.success',
		'uses'	=> 'InstallController@novaSuccess']);

	Route::get('user', [
		'as'	=> 'setup.install.user',
		'uses'	=> 'InstallController@user']);
	Route::get('user/success', [
		'as'	=> 'setup.install.user.success',
		'uses'	=> 'InstallController@userSuccess']);
	Route::post('user', [
		'as'	=> 'setup.install.user.store',
		'uses'	=> 'InstallController@createUser']);
});
