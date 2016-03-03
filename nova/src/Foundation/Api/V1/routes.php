<?php

$api = app('Dingo\Api\Routing\Router');
dd($api);

$api->version('v1', ['prefix' => 'api'], function ($api)
{
	$api->get('/', 'Nova\Foundation\Api\Controllers\V1\NovaApiController@info');

	$api->group(['middleware' => 'auth:api'], function ($api)
	{
		$api->get('pages', 'Nova\Core\Pages\Http\Api\PageController@index');
		$api->get('pages/{pageId}', 'Nova\Core\Pages\Http\Api\PageController@show');

		$api->get('page-contents', 'Nova\Core\Pages\Http\Api\PageContentController@index');
		$api->get('page-contents/{contentId}', 'Nova\Core\Pages\Http\Api\PageContentController@show');

		$api->get('access/permissions', 'Nova\Core\Access\Http\Api\PermissionController@index');
		$api->get('access/permissions/{permissionId}', 'Nova\Core\Access\Http\Api\PermissionController@show');
	});
});
