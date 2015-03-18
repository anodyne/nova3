<?php

Route::group(['prefix' => 'api'], function()
{
	Route::get('pages', 'Nova\Core\Pages\Http\Api\PageController@index');
	Route::get('pages/{pageId}', 'Nova\Core\Pages\Http\Api\PageController@show');
});
