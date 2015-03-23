<?php

Route::group(['prefix' => 'api'], function()
{
	Route::get('pages', 'Nova\Core\Pages\Http\Api\PageController@index');
	Route::get('pages/{pageId}', 'Nova\Core\Pages\Http\Api\PageController@show');

	Route::get('page-contents', 'Nova\Core\Pages\Http\Api\PageContentController@index');
	Route::get('page-contents/{contentId}', 'Nova\Core\Pages\Http\Api\PageContentController@show');
});
