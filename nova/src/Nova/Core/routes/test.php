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
		$user = UserModel::find(8);
		$characters = CharacterModel::getCharacters('npc');

		//sd($characters->toArray());
		sd($user->getPreferenceItem('loa'));
	});

	Route::get('comments', function()
	{
		return 'test/comments';

		//$model = PostModel::create(array('title' => 'Post 9'));

		//return 'Finished!';

		/*$post = PostModel::find(1);
		$post->comments()->create(array('content' => 'Fifth post comment'));

		foreach ($post->comments as $comment)
		{
			d($comment);
		}*/
	});

	Route::get('misc', function()
	{
		return Str::words("The quick fox jumped over the lazy dog.", 2);
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
		RankCatalog::install();

		$finder = new Symfony\Component\Finder\Finder();
		$finder->files()->in(SRCPATH.'Setup/assets/install/genres')->name('*.php');

		foreach ($finder as $f)
		{
			s($f->getRelativePathName());
		}
	});
});

Event::listen('eloquent.created', function($m)
{
	Log::info('Post created');
});