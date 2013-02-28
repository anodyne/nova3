<?php

use FuelPHP\FileSystem\Directory;

Route::group(array('prefix' => 'setup/utilities', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
{
	/**
	 * Uninstall Nova.
	 */
	Route::get('uninstall', function()
	{
		$data = new stdClass;
		$data->view = 'utilities/remove';
		$data->jsView = 'utilities/remove_js';
		$data->title = 'Uninstall Nova';
		$data->layout = new stdClass;
		$data->layout->label = 'Uninstall Nova';
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->message = Lang::get('setup.remove.instructions');

		$data->controls = HTML::to('setup', "I don't want to do this, get me out of here", array('class' => 'pull-right'));
		$data->controls.= Form::open('setup/utilities/uninstall').
			Form::button('Uninstall', array('class' => 'btn btn-danger', 'id' => 'next', 'name' => 'submit')).
			Form::hidden('csrf_token', csrf_token()).
			Form::close();

		return setupTemplate($data);
	});
	Route::post('uninstall', function()
	{
		// Do the QuickInstall removals
		ModuleCatalogModel::uninstall();
		RankCatalogModel::uninstall();
		SkinCatalogModel::uninstall();
		WidgetCatalogModel::uninstall();

		// Uninstall Nova
		Artisan::call('migrate:reset', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

		// Remove the system install cache
		if (File::exists(APPPATH.'storage/cache/nova_system_installed'))
		{
			Cache::forget('nova_system_installed');
		}

		return Redirect::to('setup');
	});

	/**
	 * Genre Panel.
	 */
	Route::get('genres', function()
	{
		$data = new stdClass;
		$data->view = 'utilities/genre';
		$data->jsView = 'utilities/genre_js';
		$data->title = 'The Genre Panel';
		$data->layout = new stdClass;
		$data->layout->label = 'The Genre Panel';
		$data->steps = false;
		$data->content = new stdClass;
		$data->controls = HTML::to('setup', 'Back to Setup Center', array('class' => 'pull-right'));

		// Get the genre info
		$info = Config::get('genres');

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Map the genres directory
		$fs = new Directory(SRCPATH.'Setup/assets/install/genres');
		$map = $fs->listFiles();

		// Loop through the files in the genres directory
		foreach ($map as $key => $m)
		{
			// Drop the extension off the end
			$value = str_replace('.php', '', $m);

			// Drop the path off the beginning
			$value = str_replace(SRCPATH.'Setup/assets/install/genres/', '', $value);

			if (array_key_exists($value, $info))
			{
				$genres[$value] = array(
					'name'		=> $info[$value],
					'installed' => ((bool) Schema::hasTable("{$prefix}departments_{$value}")),
				);
			}
			else
			{
				$additional[$value] = array(
					'name'		=> $value,
					'installed' => ((bool) Schema::hasTable("{$prefix}departments_{$value}")),
				);
			}
		}
		
		// Set the genres list
		$data->content->genres = (isset($genres)) ? $genres : false;
		$data->content->additional = (isset($additional)) ? $additional : false;
		
		// Set the loading image
		$data->content->loading = HTML::image('nova/src/Nova/Setup/views/design/images/loading.gif', 'Processing');

		return setupTemplate($data);
	});
});

Route::group(array('prefix' => 'setup/utilities/ajax', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
{
	Route::post('install_genre', function()
	{
		// grab the genre variable
		$genre = trim(\Security::xss_clean(\Input::post('genre')));

		// pull in the schema data
		include NOVAPATH.'setup/assets/install/fields.php';

		// build an array of genre tables that need to be added
		$tables = array(
			'departments_'.$genre => array(
				'fields' => $fields_departments),
			'positions_'.$genre => array(
				'fields' => $fields_positions),
			'ranks_'.$genre => array(
				'fields' => $fields_ranks),
		);

		foreach ($tables as $table => $value)
		{
			// set the primary key
			$primary_key = (isset($value['id'])) ? array($value['id']) : array('id');

			// set the fields for the table
			$fields = (isset($value['fields'])) ? $value['fields'] : ${'fields_'.$table};

			// create the table with the values
			\DBUtil::create_table($table, $fields, $primary_key);
			
			// if we've specified an index, create it
			if (isset($value['index']))
			{
				foreach ($value['index'] as $index)
				{
					\DBUtil::create_index($table, $index);
				}
			}
		}

		// pause the script for a second
		sleep(1);

		// pull in the genre data
		include_once NOVAPATH.'setup/assets/install/genres/'.strtolower($genre).'.php';

		$insert = array();
		
		foreach ($data as $key => $value)
		{
			foreach ($$value as $k => $v)
			{
				// do the query
				$result = \DB::insert($key)->set($v)->execute();

				// capture whether it was successful or not
				$insert[$key] = (is_array($result));
			}
		}
		
		if (in_array(false, $insert))
		{
			return json_encode(array('code' => 0));
		}
		
		// figure out what to return
		$retval = (count(\DB::list_tables('%_'.$genre)) > 0) ? array('code' => 1) : array('code' => 0);

		// create an event
		\SystemEvent::add('user', '[[event.setup.genre|{{'.$genre.'}}|action.installed]]');
		
		return json_encode($retval);
	});

	Route::post('uninstall_genre', function()
	{
		// Grab the genre
		$genre = trim(e(Input::get('genre')));

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Drop the tables
		Schema::dropIfExists("{$prefix}departments_{$genre}");
		Schema::dropIfExists("{$prefix}positions_{$genre}");
		Schema::dropIfExists("{$prefix}ranks_{$genre}");

		// Try to get one of the tables
		$hasTable = Schema::hasTable("{$prefix}departments_{$genre}");

		if ($hasTable === 0)
		{
			// Create an event
			//SystemEvent::add('user', '[[event.setup.genre|{{'.$genre.'}}|action.removed]]');

			return json_encode(array('code' => 1));
		}

		return json_encode(array('code' => 0));
	});
});