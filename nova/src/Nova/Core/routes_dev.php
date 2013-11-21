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

		//sd($user->media());
		//sd($user->getAvatar('lg'));

		Media::remove($user->getMedia());

		return 'done!';
	});

	Route::get('images', function()
	{
		$user = UserModel::find(1);

		$fileInfo = explode('.', $user->getMedia()->filename);
		$filename = $fileInfo[0];
		$extension = $fileInfo[1];

		sd($fileInfo);
	});

	Route::get('app', function()
	{
		sd(Artisan::call('nova:register', ['type' => 'install']));
	});

	Route::get('events', function()
	{
		s(Config::get('events'));
	});

	Route::get('config', function()
	{
		//s(App::make('config'));
		s(Config::module('Foo'));
		s(Config::get('app.key'));
	});

	Route::get('update', function()
	{
		$route = SystemRouteModel::find(103);

		s($route->toArray());
		$update = $route->fill(['name' => 'home2'])->save();
		s($route->toArray());
		//s($update);
	});
});