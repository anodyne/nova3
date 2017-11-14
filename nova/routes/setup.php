<?php

Route::get('/', 'SetupController@index')->name('setup.home');
Route::get('env', 'SetupController@environment')->name('setup.env');

Route::group(['prefix' => 'install'], function () {
	Route::get('/', 'InstallController@index')->name('setup.install');

	Route::get('config-database', 'ConfigDbController@info')->name('setup.install.config.db');
	Route::get('config-database/success', 'ConfigDbController@success')->name('setup.install.config.db.success');
	Route::get('config-database/write', 'ConfigDbController@write')->name('setup.install.config.db.write');
	Route::post('config-database/check', 'ConfigDbController@check')->name('setup.install.config.db.check');

	Route::get('config-email', 'ConfigEmailController@info')->name('setup.install.config.email');
	Route::get('config-email/success', 'ConfigEmailController@success')->name('setup.install.config.email.success');
	Route::post('config-email/write', 'ConfigEmailController@write')->name('setup.install.config.email.write');

	Route::get('nova', 'InstallController@installLanding')->name('setup.install.nova');
	Route::get('nova/success', 'InstallController@novaSuccess')->name('setup.install.nova.success');
	Route::post('nova', 'InstallController@install');

	Route::get('user', 'InstallController@user')->name('setup.install.user');
	Route::get('user/success', 'InstallController@userSuccess')->name('setup.install.user.success');
	Route::post('user', 'InstallController@createUser')->name('setup.install.user.store');

	Route::get('settings', 'InstallController@settings')->name('setup.install.settings');
	Route::get('settings/success', 'InstallController@settingsSuccess')->name('setup.install.settings.success');
	Route::post('settings', 'InstallController@updateSettings')->name('setup.install.settings.store');
});

Route::group(['prefix' => 'update'], function () {
	Route::get('/', 'UpdateController@index')->name('setup.update');
	Route::get('changes', 'UpdateController@changes')->name('setup.update.changes');

	Route::get('run', 'UpdateController@update')->name('setup.update.preRun');
	Route::post('run', 'UpdateController@runUpdate')->name('setup.update.run');
	Route::get('success', 'UpdateController@updateSuccess')->name('setup.update.success');
	Route::get('failed', 'UpdateController@updateFailed')->name('setup.update.failed');
});

Route::group(['prefix' => 'migrate'], function () {
	Route::get('/', 'MigrateController@index')->name('setup.migrate');

	Route::get('config-nova2', 'ConfigNova2Controller@info')->name('setup.migrate.config.nova2');
	Route::post('config-nova2/check', 'ConfigNova2Controller@check')->name('setup.migrate.config.nova2.check');
	Route::get('config-nova2/success', 'ConfigNova2Controller@success')->name('setup.migrate.config.nova2.success');

	Route::get('config-database', 'ConfigDbController@info')->name('setup.migrate.config.db');
	Route::get('config-database/success', 'ConfigDbController@success')->name('setup.migrate.config.db.success');
	Route::get('config-database/write', 'ConfigDbController@write')->name('setup.migrate.config.db.write');
	Route::post('config-database/check', 'ConfigDbController@check')->name('setup.migrate.config.db.check');

	Route::get('config-email', 'ConfigEmailController@info')->name('setup.migrate.config.email');
	Route::get('config-email/success', 'ConfigEmailController@success')->name('setup.migrate.config.email.success');
	Route::post('config-email/write', 'ConfigEmailController@write')->name('setup.migrate.config.email.write');

	Route::get('nova', 'MigrateController@migrateLanding')->name('setup.migrate.nova');
	Route::get('nova/success', 'MigrateController@migrateSuccess')->name('setup.migrate.nova.success');
	Route::post('nova', 'MigrateController@runMigration');
	Route::post('nova/migrate/{key}', 'MigrateController@runSingleMigration')->name('setup.migrate.run-single');

	Route::get('characters', 'MigrateController@verifyCharacters')->name('setup.migrate.characters');
	Route::post('characters', 'MigrateController@updateCharacters')->name('setup.migrate.characters.update');
	Route::get('characters/success', 'MigrateController@charactersSuccess')
		->name('setup.migrate.characters.success');

	Route::get('settings', 'MigrateController@settings')->name('setup.migrate.settings');
	Route::get('settings/success', 'MigrateController@settingsSuccess')->name('setup.migrate.settings.success');
	Route::post('settings', 'MigrateController@updateSettings')->name('setup.migrate.settings.store');
});
