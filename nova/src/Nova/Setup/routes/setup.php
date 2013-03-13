<?php

Route::group(array('prefix' => 'setup', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
{
	/**
	 * Setup center that determines what course of action should be taken.
	 */
	Route::get('/', function()
	{
		$data = new stdClass;
		$data->view = 'setup/index';
		$data->jsView = 'setup/index_js';
		$data->title = 'Setup Center';
		$data->layout = new stdClass;
		$data->layout->label = 'Nova Setup';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;

		// Do some checks to see what we should show
		$installed = (bool) Utility::installed();
		$update = ($installed) ? Utility::getUpdates() : false;

		if ($installed)
		{
			if (is_object($update))
			{
				/**
				 * Nova is installed and an update is available.
				 */
				$data->content->option = 3;
				$data->layout->label = 'Update Nova 3';
				$data->controls = '<a href="#" class="pull-right js-ignoreVersion" data-version="'.$update->version.'">Ignore this version</a>';
				$data->controls.= Form::open('setup/update/1').
					Form::button('Start Update', array('class' => 'btn btn-primary', 'id' => 'next', 'name' => 'submit')).
					Form::hidden('_token', csrf_token()).
					Form::close();

				// Pull in the steps indicators
				$data->steps = 'setup_update';

				// Send the update information over
				$data->content->update = new stdClass;
				$data->content->update->version = "Nova {$update->version}";
				$data->content->update->description = $update->notes;
			}
			else
			{
				/**
				 * Nova is installed and there are no updates available. Show the
				 * admin the list of utilities they can use.
				 */
				$data->content->option = 4;
				$data->layout->label = 'Nova Setup Utilities';
				$data->controls = '<a href="'.URL::to('main/index').'" class="pull-right">Back to Site</a>';
			}
		}
		else
		{
			// Get the prefix
			$prefix = DB::getTablePrefix();

			/**
			 * If we throw an exception here, it means there's no table for Nova
			 * to pull information from, so the only option is a fresh install.
			 * If there is a table to pull from, then we figure out if they're 
			 * coming from version 1 or version 2 and take the appropriate action.
			 */
			try
			{
				// Get the information from the database
				$version = DB::table('system_info')
					->where('sys_id', 1)
					->first()
					->sys_version_major;

				// Set the option
				$data->content->option = ((int) $version == 2) ? 2 : 5;

				// Nova 2 means they can do the migration
				if ($data->content->option == 2)
				{
					$data->controls = '<a href="'.URL::to('setup/install').'" class="pull-right">I\'d like to do a Fresh Install</a>';
					$data->controls.= Form::open('setup/migrate').
						Form::button('Start Migration', array(
							'class' => 'btn btn-primary',
							'id' => 'next',
							'name' => 'submit'
						)).
						Form::hidden('_token', csrf_token()).
						Form::close();
					$data->layout->label = 'Migrate From Nova 2';

					// Pull in the steps indicators
					$data->steps = 'setup_upgrade';
				}
				
				// Nova 1 means they can't do the migration
				if ($data->content->option == 5)
				{
					$data->controls = '<a href="'.URL::to('setup/install').'" class="pull-right">I\'d like to do a Fresh Install</a>';
					$data->layout->label = 'Unable to Migrate to Nova 3';
				}
			}
			catch (Exception $e)
			{
				/**
				 * The database is empty which means the only thing we can do
				 * is a fresh install of Nova 3.
				 */
				$data->content->option = 1;
				$data->controls = Form::open('setup/install').
					Form::button('Start Install', array('class' => 'btn btn-primary', 'id' => 'next', 'name' => 'submit')).
					Form::hidden('_token', csrf_token()).
					Form::close();
				$data->layout->label = 'Install Nova 3';

				// Pull in the steps indicators
				$data->steps = 'setup_install';
			}
		}

		return setupTemplate($data);
	});
	
	/**
	 * Intro to the database connection config process.
	 */
	Route::get('config', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Database Connection Setup';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Clear the installed status cache
		if (file_exists(APPPATH.'storage/cache/nova_system_installed'))
		{
			Cache::forget('nova_system_installed');
		}
		
		// Make sure we don't time out
		set_time_limit(0);
		
		if ( ! file_exists(SRCPATH.'Setup/database/db.mysql.php'))
		{
			$data->content->message = Lang::get('setup.config.text.noconfig');
			$data->layout->label = 'File Not Found';
			$data->controls = '<a href="'.URL::to('setup/config').'" class="pull-right">Try Again</a>';
		}
		else
		{
			if (file_exists(APPPATH.'config/'.App::environment().'/database.php'))
			{
				$data->content->message = Lang::get('setup.config.text.exists', array('env' => App::environment()));
				$data->controls = '<a href="'.URL::to('setup').'" class="pull-right">Back to Setup Center</a>';
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.3.7', '<'))
				{
					$data->content->message = Lang::get('setup.config.text.php', array('php' => PHP_VERSION));
					$data->layout->label = 'Installation Cannot Continue';
				}
				else
				{

					$data->content->message = Lang::get('setup.config.text.step0', array('env' => App::environment()));
					
					if (extension_loaded('mysql') or class_exists('mysqli'))
					{
						$data->controls = '<a href="'.URL::to('setup/config/info').'" class="btn btn-primary">Database Info</a>';
						
					}
					else
					{
						$data->flash = array(
							'status' => 'danger',
							'message' => Lang::get('setup.config.text.nodb'),
						);
					}
				}
			}
		}

		return setupTemplate($data);
	});
	
	/**
	 * Collect the database connection parameters.
	 */
	Route::get('config/info', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Database Info <small>Database Connection Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = 'info';

		$data->content->message = Lang::get('setup.config.text.connection');
		$data->controls = Form::button('Check Database Connection', array(
				'name' => 'next',
				'class' => 'btn btn-primary',
				'id' => 'next'
			)).
			Form::hidden('_token', csrf_token()).
			Form::close();

		return setupTemplate($data);
	});

	/**
	 * Check the values entered to see if we can connect.
	 */
	Route::post('config/check', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Check Database Connection <small>Database Connection Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Set the variables to use
		$dbName	= trim(e(Input::get('dbName')));
		$dbUser	= trim(e(Input::get('dbUser')));
		$dbPass	= trim(e(Input::get('dbPass')));
		$dbHost	= trim(e(Input::get('dbHost')));
		$prefix	= trim(e(Input::get('prefix')));
		
		// Set the session variables
		Session::put('dbName', $dbName);
		Session::put('dbUser', $dbUser);
		Session::put('dbPass', $dbPass);
		Session::put('dbHost', $dbHost);
		Session::put('prefix', $prefix);

		// Set the connection parameters
		Config::set('database.connections.mysql.host', Session::get('dbHost'));
		Config::set('database.connections.mysql.database', Session::get('dbName'));
		Config::set('database.connections.mysql.username', Session::get('dbUser'));
		Config::set('database.connections.mysql.password', Session::get('dbPass'));
		Config::set('database.connections.mysql.prefix', Session::get('prefix'));

		try
		{
			// Try to get the migration table
			$hasTable = Schema::hasTable("{$prefix}migrations");
			
			// Write the message
			$data->content->message = Lang::get('setup.config.text.step2.success');
			
			// Write the controls
			$data->controls = Form::open('setup/config/write').
				Form::button('Write Connection File', array(
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next'
				)).
				Form::hidden('_token', csrf_token()).
				Form::close();

		}
		catch (Exception $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'No such host is known') !== false)
			{
				$data->layout->label = 'Database Host Not Found';
				$data->content->message = Lang::get('setup.config.text.step2.nohost');
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				$data->layout->label = 'User/Password Issue';
				$data->content->message = Lang::get('setup.config.text.step2.userpass');
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$data->layout->label = 'Database Not Found';
				$data->content->message = Lang::get('setup.config.text.step2.dbname', array('dbname' => $dbName));
			}
			else
			{
				$data->layout->label = 'Unknown Database Issue';
				$data->content->message = Lang::get('setup.config.text.step2.gen');
			}
			
			// Write the controls
			$data->controls = '<a href="'.URL::to('setup/config/info').'" class="btn btn-primary">Start Over</a>';
		}

		return setupTemplate($data);
	});
	
	/**
	 * Write the config file.
	 */
	Route::post('config/write', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Write Database Connection <small>Database Connection Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Get the file
		$dbFileContents = File::get(SRCPATH.'Setup/database/db.mysql.php');

		if ($dbFileContents !== false)
		{
			// Set what should be replaced
			$replacements = array(
				'#DATABASE#' => Session::get('dbName'),
				'#USERNAME#' => Session::get('dbUser'),
				'#PASSWORD#' => Session::get('dbPass'),
				'#HOSTNAME#' => Session::get('dbHost'),
				'#PREFIX#'   => Session::get('prefix'),
			);

			// Loop through and do the replacements
			foreach ($replacements as $key => $value)
			{
				$dbFileContents = str_replace($key, $value, $dbFileContents);
			}

			// Try to chmod the config directory to the proper permissions
			chmod(APPPATH.'config/'.App::environment(), 0777);

			// Write the contents of the file
			$write = File::put(APPPATH.'config/'.App::environment().'/database.php', $dbFileContents);

			if ($write !== false)
			{
				// Try to chmod the file to the proper permissions
				chmod(APPPATH.'config/'.App::environment().'/database.php', 0666);

				// Set the success message
				$data->content->message = Lang::get('setup.config.text.step3write');
				
				// Wipe out the session data
				Session::flush();
				
				// Write the controls
				$data->controls = '<a href="'.URL::to('setup').'" class="btn btn-primary">Back to Setup Center</a>';
			}
			else
			{
				// Dump the code to a variable
				$data->content->code = e("<?php

return array(
'connections' => array(
'mysql' => array(
'host' => '".Session::get('dbHost')."',
'database' => '".Session::get('dbName')."',
'username' => '".Session::get('dbUser')."',
'password' => '".Session::get('dbPass')."',
'prefix' => '".Session::get('prefix')."',
),
),
);");
			
				// Set the message
				$data->content->message = Lang::get('setup.config.text.step3nowrite', array('env' => App::environment()));
				
				// Write the controls
				$data->controls = Form::open('setup/config/verify').
					Form::button('Re-Test', array(
						'class'	=> 'btn btn-primary',
						'id'	=> 'next',
						'name'	=> 'next'
					)).
					Form::hidden('_token', csrf_token()).
					Form::close();
			}
		}
		else
		{
			// Dump the code to a variable
			$data->content->code = e("<?php

return array(
'connections' => array(
'mysql' => array(
'host' => '".Session::get('dbHost')."',
'database' => '".Session::get('dbName')."',
'username' => '".Session::get('dbUser')."',
'password' => '".Session::get('dbPass')."',
'prefix' => '".Session::get('prefix')."',
),
),
);");
		
			// Set the message
			$data->content->message = Lang::get('setup.config.text.step3nowrite', array('env' => App::environment()));
			
			// Write the controls
			$data->controls = Form::open('setup/config/verify').
				Form::button('Re-Test', array(
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next'
				)).
				Form::hidden('_token', csrf_token()).
				Form::close();
		}

		return setupTemplate($data);
	});
	
	/**
	 * Verify the connection works (only used when the file can't be written).
	 */
	Route::post('config/verify', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Verify Database Connection <small>Database Connection Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		try
		{
			// Try to get the migration table
			$hasTable = Schema::hasTable("{$prefix}migrations");
			
			// Write the message
			$data->content->message = Lang::get('setup.config.text.step2.success');
			
			// Write the controls
			$data->controls = '<a href="'.URL::to('setup').'" class="btn btn-primary">Back to Setup Center</a>';
		}
		catch (Exception $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'No such host is known') !== false)
			{
				$data->layout->label = 'Database Host Not Found';
				$data->content->message = Lang::get('setup.config.text.step2.nohost');
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				$data->layout->label = 'User/Password Issue';
				$data->content->message = Lang::get('setup.config.text.step2.userpass');
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$data->layout->label = 'Database Not Found';
				$data->content->message = Lang::get('setup.config.text.step2.dbname', array('dbname' => $dbName));
			}
			else
			{
				$data->layout->label = 'Unknown Database Issue';
				$data->content->message = Lang::get('setup.config.text.step2.gen');
			}
			
			// Write the controls
			$data->controls = '<a href="'.URL::to('setup/config/info').'" class="btn btn-primary">Start Over</a>';
		}

		return setupTemplate($data);
	});

	/**
	 * Uninstall Nova.
	 */
	Route::get('uninstall', function()
	{
		$data = new stdClass;
		$data->view = 'setup/uninstall';
		$data->jsView = 'setup/uninstall_js';
		$data->title = 'Uninstall Nova';
		$data->layout = new stdClass;
		$data->layout->label = 'Uninstall Nova';
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->message = Lang::get('setup.uninstall.instructions');

		$data->controls = '<a href="'.URL::to('setup').'" class="pull-right">I don\'t want to do this, get me out of here</a>';
		$data->controls.= Form::open('setup/uninstall').
			Form::button('Uninstall', array('class' => 'btn btn-danger', 'id' => 'next', 'name' => 'submit')).
			Form::hidden('_token', csrf_token()).
			Form::close();

		return setupTemplate($data);
	});
	Route::post('uninstall', function()
	{
		// Do the QuickInstall removals
		ModuleCatalogModel::uninstall();
		RankCatalog::uninstall();
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
		$data->view = 'setup/genre';
		$data->jsView = 'setup/genre_js';
		$data->title = 'The Genre Panel';
		$data->layout = new stdClass;
		$data->layout->label = 'The Genre Panel';
		$data->steps = false;
		$data->content = new stdClass;
		$data->controls = '<a href="'.URL::to('setup').'" class="pull-right">Back to Setup Center</a>';

		// Get the genre info
		$info = Config::get('genres');

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Create a new finder
		$finder = new Symfony\Component\Finder\Finder();

		// Set what we're looking for
		$finder->files()->in(SRCPATH.'Setup/assets/install/genres')->name('*.php');

		// Loop through the files in the genres directory
		foreach ($finder as $f)
		{
			// Drop the extension off the end
			$value = str_replace('.php', '', $f->getRelativePathName());

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
		$data->content->loading = '<img src="'.URL::asset('nova/src/Nova/Setup/views/design/images/loading.gif').'" alt="Processing">';

		return setupTemplate($data);
	});
});

Route::group(array('prefix' => 'setup/ajax', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
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