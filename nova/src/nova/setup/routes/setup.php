<?php

Route::group(['prefix' => 'setup/config/db', 'before' => 'configFileCheck|setupAuthorization|csrf'], function()
{
	/**
	 * Intro to the database connection config process.
	 */
	Route::get('/', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/database';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Database Connection Setup';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Clear the installed status cache
		Cache::forget('nova.installed');
		
		// Make sure we don't time out
		set_time_limit(0);
		
		if ( ! File::exists(SRCPATH.'setup/generators/database.php'))
		{
			$data->content->message = Lang::get('setup.config.noconfig', [
				'type'	=> 'database connection',
				'file'	=> 'database',
			]);
			$data->layout->label = 'File Not Found';
			$data->controls = HTML::link('setup/config/db', 'Try Again', ['class' => 'pull-right']);
		}
		else
		{
			if (File::exists(APPPATH.'config/'.App::environment().'/database.php'))
			{
				$data->content->message = Lang::get('setup.config.exists', [
					'type'	=> 'database connection',
					'env'	=> App::environment()
				]);
				$data->controls = HTML::link('setup', 'Back to Setup Center', ['class' => 'pull-right']);
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.4.0', '<'))
				{
					$data->content->message = Lang::get('setup.config.php', ['php' => PHP_VERSION]);
					$data->layout->label = 'Installation Cannot Continue';
				}
				else
				{
					$data->content->message = Lang::get('setup.config.db.intro', ['env' => App::environment()]);
					
					if (count(PDO::getAvailableDrivers()) > 0)
					{
						$data->controls = HTML::link('setup/config/db/info', 'Start', [
							'class' => 'btn btn-primary'
						]);
					}
					else
					{
						$data->flash = array(
							'status' => 'danger',
							'message' => Lang::get('setup.config.db.nodb'),
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
	Route::get('info', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/database';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Database Info <small>Database Connection Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = 'info';

		$data->content->message = Lang::get('setup.config.db.connection');
		$data->controls = Form::button('Check Database Connection', [
				'name'	=> 'next',
				'class'	=> 'btn btn-primary',
				'id'	=> 'next',
				'type'	=> 'submit',
			]).
			Form::token().
			Form::close();

		return setupTemplate($data);
	});

	/**
	 * Check the values entered to see if we can connect.
	 */
	Route::post('check', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/database';
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
			$data->content->message = Lang::get('setup.config.db.check.success');
			
			// Write the controls
			$data->controls = Form::open(['url' => 'setup/config/db/write']).
				Form::button('Write Connection File', [
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next',
					'type'	=> 'submit',
				]).
				Form::token().
				Form::close();

		}
		catch (Exception $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'No such host is known') !== false)
			{
				$data->layout->label = 'Database Host Not Found';
				$data->content->message = Lang::get('setup.config.db.check.nohost');
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				$data->layout->label = 'User/Password Issue';
				$data->content->message = Lang::get('setup.config.db.check.userpass');
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$data->layout->label = 'Database Not Found';
				$data->content->message = Lang::get('setup.config.db.check.dbname', array('dbname' => $dbName));
			}
			else
			{
				$data->layout->label = 'Unknown Database Issue';
				$data->content->message = Lang::get('setup.config.db.check.gen');
			}
			
			// Write the controls
			$data->controls = HTML::link('setup/config/db/info', 'Start Over', array('class' => 'btn btn-primary'));
		}

		return setupTemplate($data);
	});
	
	/**
	 * Write the config file.
	 */
	Route::post('write', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/database';
		$data->jsView = false;
		$data->title = 'Database Connection Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Write Database Connection <small>Database Connection Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Get the file
		$dbFileContents = File::get(SRCPATH.'setup/generators/database.php');

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
				$data->content->message = Lang::get('setup.config.db.write.success');
				
				// Wipe out the session data
				Session::flush();
				
				// Write the controls
				$data->controls = HTML::link('setup', 'Back to Setup Center', array('class' => 'btn btn-primary'));
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
				$data->content->message = Lang::get('setup.config.db.write.failure', array('env' => App::environment()));
				
				// Write the controls
				$data->controls = Form::open(array('url' => 'setup/config/db/verify')).
					Form::button('Re-Test', array(
						'class'	=> 'btn btn-primary',
						'id'	=> 'next',
						'name'	=> 'next',
						'type'	=> 'submit',
					)).
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
			$data->content->message = Lang::get('setup.config.db.write.failure', array('env' => App::environment()));
			
			// Write the controls
			$data->controls = Form::open(array('url' => 'setup/config/db/verify')).
				Form::button('Re-Test', array(
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next',
					'type'	=> 'submit',
				)).
				Form::close();
		}

		return setupTemplate($data);
	});
	
	/**
	 * Verify the connection works (only used when the file can't be written).
	 */
	Route::post('verify', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/database';
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

			// Clear the session
			Session::flush();
			
			// Write the message
			$data->content->message = Lang::get('setup.config.db.check.success');
			
			// Write the controls
			$data->controls = HTML::link('setup', 'Back to Setup Center', array('class' => 'btn btn-primary'));
		}
		catch (Exception $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'No such host is known') !== false)
			{
				$data->layout->label = 'Database Host Not Found';
				$data->content->message = Lang::get('setup.config.db.check.nohost');
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				$data->layout->label = 'User/Password Issue';
				$data->content->message = Lang::get('setup.config.db.check.userpass');
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$data->layout->label = 'Database Not Found';
				$data->content->message = Lang::get('setup.config.db.check.dbname', array('dbname' => $dbName));
			}
			else
			{
				$data->layout->label = 'Unknown Database Issue';
				$data->content->message = Lang::get('setup.config.db.check.gen');
			}
			
			// Write the controls
			$data->controls = HTML::link('setup/config/db/info', 'Start Over', array('class' => 'btn btn-primary'));
		}

		return setupTemplate($data);
	});
});

Route::group(['prefix' => 'setup/config/email', 'before' => 'configFileCheck|setupAuthorization|csrf'], function()
{
	/**
	 * Intro to the email config process.
	 */
	Route::get('/', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/email';
		$data->jsView = false;
		$data->title = 'Email Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Email Setup';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Clear the installed status cache
		Cache::forget('nova.installed');
		
		// Make sure we don't time out
		set_time_limit(0);
		
		if ( ! File::exists(SRCPATH.'setup/generators/mail.php'))
		{
			$data->content->message = Lang::get('setup.config.noconfig', array(
				'type'	=> 'email config',
				'file'	=> 'mail',
			));
			$data->layout->label = 'File Not Found';
			$data->controls = HTML::link('setup/config/email', 'Try Again', array('class' => 'pull-right'));
		}
		else
		{
			if (File::exists(APPPATH.'config/'.App::environment().'/mail.php'))
			{
				$data->content->message = Lang::get('setup.config.exists', array(
					'type'	=> 'email config',
					'env'	=> App::environment(),
				));
				$data->controls = HTML::link('setup', 'Back to Setup Center', array('class' => 'pull-right'));
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.4.0', '<'))
				{
					$data->content->message = Lang::get('setup.config.php', array('php' => PHP_VERSION));
					$data->layout->label = 'Installation Cannot Continue';
				}
				else
				{

					$data->content->message = Lang::get('setup.config.email.intro', array('env' => App::environment()));
					$data->controls = HTML::link('setup/config/email/info', 'Start', array(
						'class' => 'btn btn-primary'
					));
				}
			}
		}

		return setupTemplate($data);
	});
	
	/**
	 * Collect the email parameters.
	 */
	Route::get('info', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/email';
		$data->jsView = 'setup/config/email_js';
		$data->title = 'Email Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Email Info <small>Email Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = 'info';

		$data->content->message = Lang::get('setup.config.email.info');
		$data->controls = Form::button('Write Config File', array(
				'name'	=> 'next',
				'class'	=> 'btn btn-primary',
				'id'	=> 'next',
				'type'	=> 'submit',
			)).
			Form::token().
			Form::close();

		return setupTemplate($data);
	});

	/**
	 * Write the config file.
	 */
	Route::post('write', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/email';
		$data->jsView = false;
		$data->title = 'Email Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Write Email Config <small>Email Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		// Set the variables to use
		$driver		= trim(e(Input::get('driver')));
		$host		= trim(e(Input::get('hostname')));
		$port		= trim(e(Input::get('port')));
		$username	= trim(e(Input::get('username')));
		$password	= trim(e(Input::get('password')));
		$encryption	= trim(e(Input::get('encryption')));
		$sendmail	= trim(e(Input::get('sendmailpath')));
		
		// Set the session variables
		Session::put('emailDrvr', $driver);
		Session::put('emailHost', $host);
		Session::put('emailPort', $port);
		Session::put('emailPass', $password);
		Session::put('emailUser', $username);
		Session::put('emailEncr', $encryption);
		Session::put('emailSend', $sendmail);

		// Get the file
		$emailFileContents = File::get(SRCPATH.'setup/generators/mail.php');

		if ($emailFileContents !== false)
		{
			// Set what should be replaced
			$replacements = [
				'#DRIVER#'		=> Session::get('emailDrvr'),
				'#HOSTNAME#'	=> Session::get('emailHost'),
				'#USERNAME#'	=> Session::get('emailUser'),
				'#PASSWORD#'	=> Session::get('emailPass'),
				"'#PORT#'"		=> Session::get('emailPort'),
				'#ENCRYPTION#'	=> Session::get('emailEncr'),
				'#SENDMAILPATH#'=> Session::get('emailSend'),
			];

			// Loop through and do the replacements
			foreach ($replacements as $key => $value)
			{
				$emailFileContents = str_replace($key, $value, $emailFileContents);
			}

			// Try to chmod the config directory to the proper permissions
			chmod(APPPATH.'config/'.App::environment(), 0777);

			// Write the contents of the file
			$write = File::put(APPPATH.'config/'.App::environment().'/mail.php', $emailFileContents);

			if ($write !== false)
			{
				// Try to chmod the file to the proper permissions
				chmod(APPPATH.'config/'.App::environment().'/mail.php', 0666);

				// Set the success message
				$data->content->message = Lang::get('setup.config.email.write.success');
				
				// Wipe out the session data
				Session::flush();
				
				// Write the controls
				$data->controls = HTML::link('setup', 'Back to Setup Center', ['class' => 'btn btn-primary']);
			}
			else
			{
				// Dump the code to a variable
				$data->content->code = e("<?php

return array(
'driver' => '".Session::get('emailDrvr')."',
'host' => '".Session::get('emailHost')."',
'port' => ".Session::get('emailPort').",
'encryption' => '".Session::get('emailEncr')."',
'username' => '".Session::get('emailUser')."',
'password' => '".Session::get('emailPass')."',
'sendmail' => '".Session::get('emailSend')."',
);");
			
				// Set the message
				$data->content->message = Lang::get('setup.config.email.write.failure', ['env' => App::environment()]);
				
				// Write the controls
				$data->controls = Form::open(['url' => 'setup/config/email/verify']).
					Form::button('Re-Test', [
						'class'	=> 'btn btn-primary',
						'id'	=> 'next',
						'name'	=> 'next',
						'type'	=> 'submit',
					]).
					Form::token().
					Form::close();
			}
		}
		else
		{
			// Dump the code to a variable
			$data->content->code = e("<?php

return array(
'driver' => '".Session::get('emailDrvr')."',
'host' => '".Session::get('emailHost')."',
'port' => ".Session::get('emailPort').",
'encryption' => '".Session::get('emailEncr')."',
'username' => '".Session::get('emailUser')."',
'password' => '".Session::get('emailPass')."',
'sendmail' => '".Session::get('emailSend')."',
);");
		
			// Set the message
			$data->content->message = Lang::get('setup.config.email.write.failure', ['env' => App::environment()]);
			
			// Write the controls
			$data->controls = Form::open(['url' => 'setup/config/email/verify']).
				Form::button('Verify', [
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next',
					'type'	=> 'submit',
				]).
				Form::token().
				Form::close();
		}

		return setupTemplate($data);
	});
	
	/**
	 * Verify the config file exists.
	 */
	Route::post('verify', function()
	{
		$data = new stdClass;
		$data->view = 'setup/config/email';
		$data->jsView = false;
		$data->title = 'Email Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Verify Email Config <small>Email Setup</small>';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->step = false;

		if (File::exists(APPPATH.'config/'.App::environment().'/mail.php'))
		{
			// Clear the session
			Session::flush();

			// Write the message
			$data->content->message = Lang::get('setup.config.email.verify.success');
			
			// Write the controls
			$data->controls = HTML::link('setup', 'Back to Setup Center', ['class' => 'btn btn-primary']);
		}
		else
		{
			$data->layout->label = 'Email Config File Not Found';
			$data->content->message = Lang::get('setup.config.email.verify.failure');

			// Write the controls
			$data->controls = HTML::link('setup/config/email/info', 'Start Over', ['class' => 'btn btn-primary']);
		}

		return setupTemplate($data);
	});
});

Route::group(array('prefix' => 'setup/ajax', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
{
	/**
	 * Ignore the update notification for a version.
	 */
	Route::post('ignore_version', function()
	{
		// Update the system information table with the ignore version
		System::updateInfo(array(
			'ignore' => Input::get('version')
		));
	});

	/**
	 * Install a new genre.
	 */
	Route::post('install_genre', function()
	{
		// Grab the genre
		$genre = trim(e(Input::get('genre')));

		// Create new instances of the migrations
		$depts = new NovaCreateDepartments;
		$positions = new NovaCreatePositions;
		$ranks = new NovaCreateRanks;

		// Drop the items
		$depts->up($genre);
		$positions->up($genre);
		$ranks->up($genre);

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Try to get one of the tables
		$hasTable = Schema::hasTable("{$prefix}departments_{$genre}");

		if ($hasTable)
		{
			// Create an event
			SystemEvent::addUserEvent('event.setup.genre', $genre, lang('action.installed'));

			return json_encode(array('code' => 1));
		}

		return json_encode(array('code' => 0));
	});

	/**
	 * Uninstall an existing genre.
	 */
	Route::post('uninstall_genre', function()
	{
		// Grab the genre
		$genre = trim(e(Input::get('genre')));

		// Create new instances of the migrations
		$depts = new NovaCreateDepartments;
		$positions = new NovaCreatePositions;
		$ranks = new NovaCreateRanks;

		// Drop the items
		$depts->down($genre);
		$positions->down($genre);
		$ranks->down($genre);

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Try to get one of the tables
		$hasTable = Schema::hasTable("{$prefix}departments_{$genre}");

		if ( ! $hasTable)
		{
			// Create an event
			SystemEvent::addUserEvent('event.setup.genre', $genre, lang('action.removed'));

			return json_encode(array('code' => 1));
		}

		return json_encode(array('code' => 0));
	});
});