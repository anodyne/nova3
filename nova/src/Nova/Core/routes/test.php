<?php

Route::group(array('prefix' => 'test'), function()
{
	Route::get('citadel', function()
	{
		$user = Sentry::getUserProvider()->findById(8);

		$role = Sentry::getGroupProvider()->findByName('Power User')->getPermissions();

		sd($role);
		sd($user->inGroup($role));
	});

	Route::get('user', function()
	{
		s(User::active()->get());
	});

	Route::get('comments', function()
	{
		return 'test/comments';

		//$model = Post::create(array('title' => 'Post 9'));

		//return 'Finished!';

		/*$post = Post::find(1);
		$post->comments()->create(array('content' => 'Fifth post comment'));

		foreach ($post->comments as $comment)
		{
			d($comment);
		}*/
	});

	Route::get('misc', function()
	{
		s(RankCatalog::test());
	});

	Route::get('migrate', function()
	{
		set_time_limit(0);

		// Run the migrations
		Artisan::call('migrate', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

		// Seed the database with dev data
		//Artisan::call('db:seed');

		// Uninstall everything
		//Artisan::call('migrate:reset', array('--package' => 'application'));

		return 'Migrations have run!';
	});

	Route::get('cache', function()
	{
		// Cache something forever
		//Cache::forever('nova_module_list', array('foo', 'bar', 'test'));

		// Cache something for 1 minute
		//Cache::put('foo', 'FOO', 1);

		//Cache::forget('module_list');

		var_dump(Cache::get('nova_module_list'));
	});

	Route::get('finder', function()
	{
		$roles = AccessRole::all();

		sd($roles->toSimpleArray());
	});

	Route::get('events', function()
	{
		User::add(array(
			'name' => 'John Doe', 
			'email' => 'john.doe@example.com', 
			'password' => 'foo',
		));
	});

	Route::get('macros', function()
	{
		//echo Form::department('dept');
		//echo Form::languages('language');
		//echo Form::position('position');
		//echo Form::rank('rank');
		//echo Form::roles('role');
		//echo Form::timezones('timezone');
		echo Form::users('users');
		//echo Form::characters('characters');
	});
});