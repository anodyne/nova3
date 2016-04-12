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
		$api->get('pages', 'PageApiController@index')->name('api.pages.index');
		$api->get('pages/{pageId}', 'PageApiController@show')->name('api.pages.show');

		$api->get('page-contents', 'PageContentApiController@index')->name('api.page-contents.index');
		$api->get('page-contents/{contentId}', 'PageContentApiController@show')->name('api.page-contents.show');

		$api->get('access/permissions', 'PermissionApiController@index')->name('api.access.permissions.index');
		$api->get('access/permissions/{permissionId}', 'PermissionApiController@show')->name('api.access.permissions.show');
	});
});
