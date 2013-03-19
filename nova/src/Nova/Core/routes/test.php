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
		$characters = Character::getCharacters('npc');

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
		dd(SettingsModel::getItems());

		//dd(Character::getCharacters()->toArray());

		//$depts = DeptModel::where('type', 'nonplaying')->with('positions')->get();

		//dd($depts->toArray());

		$positions = PositionModel::getItems('open.playing')->filter(function($item)
			{
				return ($item->type == 'senior');
			});
		/*$positions = PositionModel::with(array('dept.positions' => function($query)
		{
			$query->where('type', 'nonplaying');
		}))->get();*/
		//$positions = PositionModel::find(1);

		dd($positions->toArray());
		//dd($positions);

		foreach ($positions as $p)
		{
			//d($p->name);
			//d($p->dept->name);
		}
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
});