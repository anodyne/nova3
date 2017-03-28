<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (! nova()->isInstalled()) {
	Route::get('/', 'Nova\Core\Game\Http\Controllers\HomeController@page');
} else {
	// Grab an instance of the router
	$router = app('router');

	// Get all the pages out of the container
	$pages = app('nova.pages');

	if ($pages->count() > 0) {
		// Allowed HTTP verbs
		$allowedVerbs = collect(['get', 'post', 'put', 'delete']);

		// Go through the pages and build the routes
		$pages->each(function ($page) use ($allowedVerbs, $router) {
			// Get the page's verb and format it
			$verb = strtolower($page->verb);

			// Make sure the page is using one of the allowed verbs
			if ($allowedVerbs->contains($verb)) {
				// Call the appropriate method on the $router
				call_user_func_array([$router, $verb], [$page->uri, [
					'as' => $page->key,
					'uses' => ($page->resource) ?: $page->default_resource,
				]]);
			}
		});
	}
}
