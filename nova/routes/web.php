<?php

Route::get('/', function () {
	view()->share('_user', auth()->user());

	return view('pages.welcome');
})->name('home')->middleware('nova.installed');

Route::group(['namespace' => 'Nova\Auth\Http\Controllers'], function () {
	// Authentication Routes...
	Route::get('sign-in', 'SignInController@showSignInForm')->name('sign-in');
	Route::post('sign-in', 'SignInController@login');
	Route::post('sign-out', 'SignInController@logout')->name('sign-out');

	// Password Reset Routes...
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')
		->name('password.request');
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
		->name('password.email');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
		->name('password.reset');
	Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::get('join', function () {
	// Placeholder for the join page
})->name('join');

Route::get('admin/departments/reorder', 'Nova\Genres\Http\Controllers\ReorderDepartmentsController@index')
	->name('departments.reorder');
Route::patch('admin/departments/reorder', 'Nova\Genres\Http\Controllers\ReorderDepartmentsController@update');
Route::resource('admin/departments', 'Nova\Genres\Http\Controllers\DepartmentsController');

Route::patch('admin/positions/reorder', 'Nova\Genres\Http\Controllers\PositionsController@reorder')
	->name('positions.reorder');
Route::patch('admin/positions', 'Nova\Genres\Http\Controllers\PositionsController@update')
	->name('positions.update');
Route::resource('admin/positions', 'Nova\Genres\Http\Controllers\PositionsController', ['except' => ['edit', 'update']]);

Route::get('admin/ranks', 'Nova\Genres\Http\Controllers\RanksController@index')->name('ranks.index');

/**
 * Rank Groups
 */
Route::post('admin/ranks/groups/{group}/duplicate', 'Nova\Genres\Http\Controllers\RankGroupsController@duplicate')
	->name('ranks.groups.duplicate');
Route::get('admin/ranks/groups/duplicate-confirm', 'Nova\Genres\Http\Controllers\RankGroupsController@duplicateConfirm')
	->name('ranks.groups.duplicate-confirm');
Route::patch('admin/ranks/groups/reorder', 'Nova\Genres\Http\Controllers\RankGroupsController@reorder')
	->name('ranks.groups.reorder');
Route::patch('admin/ranks/groups', 'Nova\Genres\Http\Controllers\RankGroupsController@update')
	->name('ranks.groups.update');
Route::resource(
	'admin/ranks/groups',
	'Nova\Genres\Http\Controllers\RankGroupsController',
	['names' => 'ranks.groups', 'except' => ['edit', 'update']]
);

/**
 * Rank Info
 */
Route::patch('admin/ranks/info', 'Nova\Genres\Http\Controllers\RankInfoController@update')
	->name('ranks.info.update');
Route::patch('admin/ranks/info/reorder', 'Nova\Genres\Http\Controllers\RankInfoController@reorder')
	->name('ranks.info.reorder');
Route::resource(
	'admin/ranks/info',
	'Nova\Genres\Http\Controllers\RankInfoController',
	['names' => 'ranks.info', 'except' => ['edit', 'update']]
);

/**
 * Rank Items
 */
Route::post('admin/ranks/items/{item}/duplicate', 'Nova\Genres\Http\Controllers\RankItemsController@duplicate')
	->name('ranks.items.duplicate');
Route::patch('admin/ranks/items/reorder', 'Nova\Genres\Http\Controllers\RankItemsController@reorder')
	->name('ranks.items.reorder');
Route::resource('admin/ranks/items', 'Nova\Genres\Http\Controllers\RankItemsController', ['names' => 'ranks.items']);

/**
 * Authorization
 */
Route::resource('admin/roles', 'Nova\Authorize\Http\Controllers\RolesController');
Route::resource('admin/permissions', 'Nova\Authorize\Http\Controllers\PermissionsController');

// Make sure for restoring we can get the actual object
app('router')->bind('user', function ($value) {
	return Nova\Users\User::withTrashed()->where('id', $value)->first();
});

Route::patch('admin/users/{user}/restore', 'Nova\Users\Http\Controllers\UsersController@restore')
	->name('users.restore');
Route::get('admin/users/password-resets', 'Nova\Users\Http\Controllers\ForcePasswordResetsController@index')
	->name('users.force-password-reset');
Route::patch('admin/users/password-resets', 'Nova\Users\Http\Controllers\ForcePasswordResetsController@update')
	->name('users.reset-passwords');
Route::patch('admin/users/{user}/activate', 'Nova\Users\Http\Controllers\UsersActivatorController@update')
	->name('users.activate');
Route::delete('admin/users/{user}/deactivate', 'Nova\Users\Http\Controllers\UsersActivatorController@destroy')
	->name('users.deactivate');
Route::resource('admin/users', 'Nova\Users\Http\Controllers\UsersController');

Route::get('profile/edit', 'Nova\Users\Http\Controllers\ProfilesController@edit')
	->name('profile.edit');
Route::patch('profile', 'Nova\Users\Http\Controllers\ProfilesController@update')
	->name('profile.update');
Route::patch('profile/change-password', 'Nova\Users\Http\Controllers\ProfilesController@updatePassword')
	->name('profile.password');
Route::get('profile/{user}', 'Nova\Users\Http\Controllers\ProfilesController@show')
	->name('profile.show');

// Make sure for restoring we can get the actual object
app('router')->bind('character', function ($value) {
	return Nova\Characters\Character::withTrashed()->where('id', $value)->first();
});

Route::get('admin/characters/link', 'Nova\Characters\Http\Controllers\LinkCharactersController@create')
	->name('characters.link');
Route::post('admin/characters/link', 'Nova\Characters\Http\Controllers\LinkCharactersController@store')
	->name('characters.link.store');
Route::patch('admin/characters/link', 'Nova\Characters\Http\Controllers\LinkCharactersController@update')
	->name('characters.link.update');
Route::delete('admin/characters/unlink/{character}', 'Nova\Characters\Http\Controllers\LinkCharactersController@destroy')
	->name('characters.link.destroy');

Route::patch('admin/characters/{character}/restore', 'Nova\Characters\Http\Controllers\CharactersController@restore')
	->name('characters.restore');

Route::patch('admin/characters/{character}/activate', 'Nova\Characters\Http\Controllers\CharactersActivatorController@update')
	->name('characters.activate');
Route::delete('admin/characters/{character}/deactivate', 'Nova\Characters\Http\Controllers\CharactersActivatorController@destroy')
	->name('characters.deactivate');

Route::resource('admin/characters', 'Nova\Characters\Http\Controllers\CharactersController');

Route::get('characters/manifest', 'Nova\Characters\Http\Controllers\CharacterManifestController@index')
	->name('characters.manifest');
Route::get('characters/bio/{character}', 'Nova\Characters\Http\Controllers\CharacterBioController@show')
	->name('characters.bio');

/**
 * Media
 */
Route::post('admin/media', 'Nova\Media\Http\Controllers\MediaController@store')
	->name('media.store');
Route::patch('admin/media/{media}', 'Nova\Media\Http\Controllers\MediaController@update')
	->name('media.update');
Route::delete('admin/media/{media}', 'Nova\Media\Http\Controllers\MediaController@destroy')
	->name('media.destroy');
Route::patch('admin/media', 'Nova\Media\Http\Controllers\MediaController@reorder')
	->name('media.reorder');

/**
 * Dashboard
 */
$dashboardOptions = [
	'prefix' => 'dashboard',
	'namespace' => 'Nova\Dashboard\Http\Controllers'
];

Route::group($dashboardOptions, function () {
	Route::get('/', 'DashboardController@index')
		->name('dashboard');
	Route::get('dashboard/characters', 'DashboardController@characters')
		->name('dashboard.characters');
	Route::get('audit', 'AuditController@index')
		->name('dashboard.audit');

	Route::post('dashboard/finish-install', 'DashboardController@finishInstallation')
		->name('dashboard.finish-install');
	Route::post('dashboard/finish-migrate', 'DashboardController@finishMigration')
		->name('dashboard.finish-migrate');
	Route::post('dashboard/send-test-email', 'DashboardController@sendTestEmail')
		->name('dashboard.send-test-email');
});

/**
 * Settings
 */
Route::get('admin/settings', 'Nova\Settings\Http\Controllers\SettingsController@index')
	->name('settings');
Route::patch('admin/settings', 'Nova\Settings\Http\Controllers\SettingsController@update')
	->name('settings.update');

/**
 * Extensions & Themes
 */
Route::resource('admin/extensions', 'Nova\Extensions\Http\Controllers\ExtensionsController');
Route::resource('admin/themes', 'Nova\Themes\Http\Controllers\ThemesController');

Route::get('admin/tokens', 'Nova\Tokens\Http\Controllers\TokensController@handle')->name('tokens');
