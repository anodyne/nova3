<?php

Route::group(['prefix' => 'api'], function ()
{
	get('pages', 'Nova\Core\Pages\Http\Api\PageController@index');
	get('pages/{pageId}', 'Nova\Core\Pages\Http\Api\PageController@show');

	get('page-contents', 'Nova\Core\Pages\Http\Api\PageContentController@index');
	get('page-contents/{contentId}', 'Nova\Core\Pages\Http\Api\PageContentController@show');

	get('access/permissions', 'Nova\Core\Access\Http\Api\PermissionController@index');
	get('access/permissions/{permissionId}', 'Nova\Core\Access\Http\Api\PermissionController@show');
});
