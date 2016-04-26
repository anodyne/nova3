<?php

use Spatie\Menu\Laravel\Menu as MenuBuilder,
	Spatie\Menu\Laravel\Link as LinkBuilder;

/**
 * THIS FILE IS FOR TEST PURPOSES ONLY AND WILL NOT BE AVAILABLE WHEN NOVA 3.0
 * IS RELEASED. ONLY USE THIS FILE FOR TESTING OR DEBUGGING DURING NOVA
 * NEXTGEN DEVELOPMENT!
 */

Route::get('test', function ()
{
	$page = Page::find(9);
	$theme = new Nova\Foundation\Services\Themes\Theme('pulsar', app());
	$menu = $theme->menuNew($page);

	echo $menu->render();

	dd($menu->render());

	return 'Done';
});
