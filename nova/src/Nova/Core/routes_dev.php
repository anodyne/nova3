<?php

Route::group(['prefix' => 'dev'], function()
{
	/*Route::get('/{string?}', function()
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
	});*/

	Route::get('media', function()
	{
		// Get a user
		$user = UserModel::find(1);

		//$media = $user->media()->create(['filename' => 'moreno.jpg', 'user_id' => $user->id]);

		sd($user->media());
		//sd($user->getAvatar('lg'));

		return 'done!';
	});
});