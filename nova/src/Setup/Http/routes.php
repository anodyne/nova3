<?php

$options = [
	'prefix'		=> 'setup',
	'namespace'		=> 'Nova\Setup\Http\Controllers'
];

Route::group($options, function()
{
	Route::get('/', [
		'as'	=> 'setup.home',
		'uses'	=> 'SetupController@index']);

	Route::get('install', [
		'as'	=> 'setup.install',
		'uses'	=> 'SetupController@install']);

	Route::get('start', [
		'as'	=> 'setup.start',
		'uses'	=> 'SetupController@start']);

	Route::get('config/email', [
		'as'	=> 'setup.config.email',
		'uses'	=> 'EmailConfigController@index']);

	Route::get('update', [
		'as'	=> 'setup.update',
		'uses'	=> 'SetupController@update']);
});

$configDbOptions = array_merge($options, [
	'prefix'		=> 'setup/config/db',
]);

Route::group($configDbOptions, function()
{
	Route::get('/', [
		'as'	=> 'setup.config.db',
		'uses'	=> 'ConfigDbController@info']);

	Route::post('check', [
		'as'	=> 'setup.config.db.check',
		'uses'	=> 'ConfigDbController@check']);
	Route::post('write', [
		'as'	=> 'setup.config.db.write',
		'uses'	=> 'ConfigDbController@write']);
	Route::post('verify', [
		'as'	=> 'setup.config.db.verify',
		'uses'	=> 'ConfigDbController@verify']);
});

/*Route::group(['prefix' => 'setup/config/email', 'before' => 'csrf'], function()
{
	Route::get('/', 'Nova\Setup\Controllers\ConfigMailController@getIndex');
	Route::get('info', 'Nova\Setup\Controllers\ConfigMailController@getInfo');
	
	Route::post('write', 'Nova\Setup\Controllers\ConfigMailController@postWrite');
	Route::post('verify', 'Nova\Setup\Controllers\ConfigMailController@postVerify');
});*/