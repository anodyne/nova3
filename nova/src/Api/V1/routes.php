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
		$api->get('pages/{pageId}', 'PageApiController@show');

		$api->get('page-contents', 'PageContentApiController@index');
		$api->get('page-contents/{contentId}', 'PageContentApiController@show');

		//$api->get('access/roles', 'RoleApiController@index');
		//$api->get('access/roles/{roleId}', 'RoleApiController@show');

		$api->get('access/permissions', 'PermissionApiController@index');
		$api->get('access/permissions/{permissionId}', 'PermissionApiController@show');
	});
});
