<?php

$api = app('Dingo\Api\Routing\Router');

$options = [
	'prefix' => 'api',
	'namespace' => 'Nova\Api\V1\Controllers',
	//'middleware' => 'api.throttle',
];

$api->version('v1', $options, function ($api)
{
	$api->get('/', 'NovaApiController@info');

	$api->group([], function ($api)
	{
		/**
		 * Pages
		 */
		$api->get('pages', 'PageApiController@index')->name('api.pages.index');
		$api->get('pages/{pageId}', 'PageApiController@show')->name('api.pages.show');
		$api->get('page-contents', 'PageContentApiController@index')->name('api.page-contents.index');
		$api->get('page-contents/{contentId}', 'PageContentApiController@show')->name('api.page-contents.show');

		/**
		 * Access
		 */
		$api->get('access/roles', 'RoleApiController@all')->name('api.access.roles.all');
		$api->get('access/roles/{roleId}', 'RoleApiController@show')->name('api.access.roles.show');
		$api->get('access/permissions', 'PermissionApiController@all')->name('api.access.permissions.all');
		$api->get('access/permissions/{permissionId}', 'PermissionApiController@show')->name('api.access.permissions.show');

		/**
		 * Users
		 */
		$api->get('users', 'UserApiController@all')->name('api.users.index');
		$api->get('users/{userId}', 'UserApiController@show')->name('api.users.show');
	});
});
