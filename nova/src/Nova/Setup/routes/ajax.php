<?php

Route::group(array('prefix' => 'setup/ajax', 'before' => 'configFileCheck|setupAuthorization'), function()
{
	Route::get('ignore_version', function()
	{
		// Update the system information table with the ignore version
		System::updateInfo(array(
			'version_ignore' => Input::post('version')
		));
	});

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