<?php

// Get all the pages
$pages = app('PageRepository')->all();

if ($pages->count() > 0)
{
	foreach ($pages as $page)
	{
		$options['as'] = $page->key;
		$options['uses'] = ($page->resource) ?: $page->default_resource;

		call_user_func_array([$router, strtolower($page->verb)], [$page->uri, $options]);
	}
}

//Route::get('admin/pages', 'Nova\Core\Pages\Http\Controllers\PageController@index');
//Route::get('admin/pages/{pageId}/edit', 'Nova\Core\Pages\Http\Controllers\PageController@edit');
