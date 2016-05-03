<?php

/**
 * THIS FILE IS FOR TEST PURPOSES ONLY AND WILL NOT BE AVAILABLE WHEN NOVA 3.0
 * IS RELEASED. ONLY USE THIS FILE FOR TESTING OR DEBUGGING DURING NOVA
 * NEXTGEN DEVELOPMENT!
 */

Route::get('icons', 'Nova\Core\Game\Http\Controllers\HomeController@icons');

Route::get('test', function ()
{
	$page = Page::find(9);
	$theme = new Nova\Foundation\Services\Themes\Theme('pulsar', app());
	$menu = $theme->menuNew($page);

	echo $menu['menuSub']->render();

	dd($menu['menuSub']->render());

	return 'Done';
});
