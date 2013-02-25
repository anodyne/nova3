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
				$data->controls = "<a href='#' class='pull-right js-ignoreVersion' data-version='{$update->version}'>Ignore this version</a>";
				$data->controls.= Form::open('setup/update/1').
					Form::button('Start Update', array('class' => 'btn btn-primary', 'id' => 'next', 'name' => 'submit')).
					Form::hidden('csrf_token', csrf_token()).
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
				$data->controls = '<a href="'.URL::to('main/index').'" class="pull-right">Back to site</a>';
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
					$data->controls = "<a href='".URL::to('setup/install')."' class='pull-right'>I'd like to do a Fresh Install instead</a>";
					$data->controls.= Form::open('setup/migrate').
						Form::button('Start Migration', array('class' => 'btn btn-primary', 'id' => 'next', 'name' => 'submit')).
						Form::hidden('csrf_token', csrf_token()).
						Form::close();
					$data->layout->label = 'Migrate From Nova 2';

					// Pull in the steps indicators
					$data->steps = 'setup_upgrade';
				}
				
				// Nova 1 means they can't do the migration
				if ($data->content->option == 5)
				{
					$data->controls = "<a href='".URL::to('setup/install')."' class='pull-right'>I'd like to do a Fresh Install instead</a>";
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
					Form::hidden('csrf_token', csrf_token()).
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
			$data->controls = '<a href="'.URL::to('setup/config').'" class="pull-right">Try again</a>';
		}
		else
		{
			if (file_exists(APPPATH.'config/'.App::environment().'/database.php'))
			{
				$data->content->message = Lang::get('setup.config.text.exists', array('env' => App::environment()));
				$data->controls = '<a href="'.URL::to('setup/config/info').'" class="pull-right">Back to Setup Center</a>';
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
						$data->controls = '<a href="'.URL::to('setup/config/info').'" class="btn btn-primary">Next Step</a>';
						
					}
					else
					{
						$data->flash[] = array(
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
			Form::hidden('csrf_token', csrf_token()).
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
		$dbName		= trim(e(Input::get('dbName')));
		$dbUser		= trim(e(Input::get('dbUser')));
		$dbPass		= trim(e(Input::get('dbPass')));
		$dbHost		= trim(e(Input::get('dbHost')));
		$prefix		= trim(e(Input::get('prefix')));
		
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
					'type'	=> 'submit',
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next'
				)).
				Form::hidden('csrf_token', csrf_token()).
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

		// Grab the disabled functions
		$disabled = explode(',', ini_get('disable_functions'));
		
		// Make sure everything is trimmed properly
		foreach ($disabled as $key => $value)
		{
			$disabled[$key] = trim($value);
		}
		
		// What we need
		$need = array('fopen', 'fwrite', 'file');
		
		// Check to make sure we have what we need
		$check = array_intersect($disabled, $need);
		
		// Pull in the mysql file
		$file = file(SRCPATH.'Setup/database/db.mysql.php');
		
		if (is_array($file))
		{
			foreach ($file as $lineNumber => $line)
			{
				switch (substr($line, 0, 9))
				{
					case "'database":
						$file[$lineNumber] = str_replace("#DATABASE#", Session::get('dbName'), $line);
					break;
					
					case "'username":
						$file[$lineNumber] = str_replace("#USERNAME#", Session::get('dbUser'), $line);
					break;
					
					case "'password":
						$file[$lineNumber] = str_replace("#PASSWORD#", Session::get('dbPass'), $line);
					break;
					
					case "'host' =>":
						$file[$lineNumber] = str_replace("#HOSTNAME#", Session::get('dbHost'), $line);
					break;
					
					case "'prefix' ":
						$file[$lineNumber] = str_replace("#PREFIX#", Session::get('prefix'), $line);
					break;
				}
			}
			
			$code = false;
			
			foreach ($file as $value)
			{
				$code.= htmlentities($value);
			}
		}
		else
		{
			$code = htmlentities("<?php

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
		}
		
		if (count($check) == 0)
		{
			try
			{
				// Try to chmod the config directory to the proper permissions
				chmod(APPPATH.'config/'.App::environment(), 0777);
			}
			catch (Exception $e)
			{
				// Add the message
				Log::error('Could not change file permissions of the config directory to 0777. Please do so manually.');
			}
			
			// Open the file
			$handle = fopen(APPPATH.'config/'.App::environment().'/database.php', 'w');
			
			// Figure out if the write was successful
			$write = false;
		
			// Write the file line by line
			foreach ($file as $line)
			{
				$write = fwrite($handle, $line);
			}
			
			// Close the file
			fclose($handle);
			
			try
			{
				// Try to chmod the file to the proper permissions
				chmod(APPPATH.'config/'.App::environment().'/database.php', 0666);
			}
			catch (Exception $e)
			{
				// Add the message
				Log::error('Could not change file permissions of the database configuration file to 0666. Please do so manually.');
			}
			
			if ($write !== false)
			{
				// Set the success message
				$data->content->message = Lang::get('setup.config.text.step3write');
				
				// Wipe out the session
				Session::flush();
				
				// Write the controls
				$data->controls = '<a href="'.URL::to('setup').'" class="btn btn-primary">Back to Setup Center</a>';
			}
			else
			{
				$data->content->code = $code;
			
				$data->content->message = Lang::get('setup.config.text.step3nowrite', array(
					'env' => App::environment())
				);
				
				// Write the controls
				$data->controls = Form::open('setup/config/check').
					Form::button('Re-Test', array(
						'type'	=> 'submit',
						'class'	=> 'btn btn-primary',
						'id'	=> 'next',
						'name'	=> 'next'
					)).
					Form::hidden('csrf_token', csrf_token()).
					Form::close();
			}
		}
		else
		{
			$data->content->code = $code;
			
			$data->content->message = Lang::get('setup.config.text.step3nowrite', array(
				'env' => App::environment())
			);
			
			// Write the controls
			$data->controls = Form::open('setup/config/check').
				Form::button('Re-Test', array(
					'type'	=> 'submit',
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next'
				)).
				Form::hidden('csrf_token', csrf_token()).
				Form::close();
		}

		return setupTemplate($data);
	});
});