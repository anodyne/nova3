<?php

Route::group(['prefix' => 'dev'], function()
{
	Route::get('/{string?}', function()
	{
		// Find the record that matches the URI
		$route = SystemRouteModel::name('home')->get();

		// Get the final route to use
		$finalRoute = ($route->count() > 1)
			? $route->filter(function($r){ return (bool) $r->protected === false; })->first()
			: $route->first();

		s(Cache::get('nova.routes'));
		s($route->toArray());
		s($finalRoute->toArray());
	});
});