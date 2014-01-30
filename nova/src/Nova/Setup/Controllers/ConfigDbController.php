<?php namespace Nova\Setup\Controllers;

use App,
	File,
	Form,
	HTML,
	Cache,
	Input,
	Config,
	Schema,
	Session,
	SetupBaseController;
use PDO,
	Exception;

class ConfigDbController extends SetupBaseController {

	public function getIndex()
	{
		// Set the view
		$this->view = 'setup/config/database';

		// Set up the title and header
		$this->title = $this->header = 'Database Connection Setup';

		// Set the step
		$this->data->step = false;

		// Clear the installed status cache
		Cache::forget('nova.installed');
		
		// Make sure we don't time out
		set_time_limit(0);
		
		if ( ! File::exists(SRCPATH.'Setup/generators/database.php'))
		{
			$this->data->message = lang('setup.config.noconfig', 'database connection', 'database');
			$this->header = 'File Not Found';
			$this->controls = HTML::link('setup/config/db', 'Try Again', ['class' => 'pull-right']);
		}
		else
		{
			if (File::exists(APPPATH.'config/'.App::environment().'/database.php'))
			{
				$this->data->message = lang('setup.config.exists', 'database connection', App::environment());
				$this->controls = HTML::link('setup', 'Back to Setup Center', ['class' => 'pull-right']);
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.4.0', '<'))
				{
					$this->data->message = lang('setup.config.php', PHP_VERSION);
					$this->header = 'Installation Cannot Continue';
				}
				else
				{
					$this->data->message = lang('setup.config.db.intro', App::environment());
					
					if (count(PDO::getAvailableDrivers()) > 0)
					{
						$this->controls = HTML::link('setup/config/db/info', 'Start', [
							'class' => 'btn btn-primary'
						]);
					}
					else
					{
						$this->flash[] = [
							'status'	=> 'danger',
							'message'	=> lang('setup.config.db.nodb'),
						];
					}
				}
			}
		}
	}

	public function getInfo()
	{
		// Set the view
		$this->view = 'setup/config/database';

		// Set the title and header
		$this->title = 'Database Connection Setup';
		$this->header = 'Database Info <small>Database Connection Setup</small>';

		// Set the step
		$this->data->step = 'info';

		$this->data->message = lang('setup.config.db.connection');
		$this->controls = Form::button('Check Database Connection', [
				'name'	=> 'next',
				'class'	=> 'btn btn-primary',
				'id'	=> 'next',
				'type'	=> 'submit',
			]).
			Form::token().
			Form::close();
	}

	public function postCheck()
	{
		// Set the view
		$this->view = 'setup/config/database';

		// Set the title and header
		$this->title = 'Database Connection Setup';
		$this->header = 'Check Database Connection <small>Database Connection Setup</small>';

		// Set the step
		$this->data->step = false;

		// Set the session variables
		Session::put('dbName', trim(e(Input::get('dbName'))));
		Session::put('dbUser', trim(e(Input::get('dbUser'))));
		Session::put('dbPass', trim(e(Input::get('dbPass'))));
		Session::put('dbHost', trim(e(Input::get('dbHost'))));
		Session::put('prefix', trim(e(Input::get('prefix'))));

		// Set the connection parameters
		Config::set('database.connections.mysql.host', Session::get('dbHost'));
		Config::set('database.connections.mysql.database', Session::get('dbName'));
		Config::set('database.connections.mysql.username', Session::get('dbUser'));
		Config::set('database.connections.mysql.password', Session::get('dbPass'));
		Config::set('database.connections.mysql.prefix', Session::get('prefix'));

		try
		{
			// Try to get the migration table
			$hasTable = Schema::hasTable(Session::get('prefix')."migrations");
			
			// Write the header and message
			$this->header = 'Successful Connection';
			$this->data->message = lang('setup.config.db.check.success');
			
			// Write the controls
			$this->controls = Form::open(['url' => 'setup/config/db/write']).
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
				$this->header = 'Database Host Not Found';
				$this->data->message = lang('setup.config.db.check.nohost');
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				$this->header = 'User/Password Issue';
				$this->data->message = lang('setup.config.db.check.userpass');
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$this->header = 'Database Not Found';
				$this->data->message = lang('setup.config.db.check.dbname', Session::get('dbName'));
			}
			else
			{
				$this->header = 'Unknown Database Issue';
				$this->data->message = lang('setup.config.db.check.gen');
			}
			
			// Write the controls
			$this->controls = HTML::link('setup/config/db/info', 'Start Over', ['class' => 'btn btn-primary']);
		}
	}

	public function postWrite()
	{
		// Set the view
		$this->view = 'setup/config/database';

		// Set the title and header
		$this->title = 'Database Connection Setup';
		$this->header = 'Write Database Connection <small>Database Connection Setup</small>';

		// Set the step
		$this->data->step = false;

		// Get the file
		$dbFileContents = File::get(SRCPATH.'Setup/generators/database.php');

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
				$this->data->message = lang('setup.config.db.write.success');
				
				// Wipe out the session data
				Session::flush();
				
				// Write the controls
				$this->controls = HTML::link('setup', 'Back to Setup Center', ['class' => 'btn btn-primary']);
			}
			else
			{
				// Dump the code to a variable
				$this->data->code = e("<?php

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
				$this->data->message = lang('setup.config.db.write.failure', App::environment());
				
				// Write the controls
				$this->controls = Form::open(['url' => 'setup/config/db/verify']).
					Form::button('Re-Test', [
						'class'	=> 'btn btn-primary',
						'id'	=> 'next',
						'name'	=> 'next',
						'type'	=> 'submit',
					]).
					Form::close();
			}
		}
		else
		{
			// Dump the code to a variable
			$this->data->code = e("<?php

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
			$this->data->message = lang('setup.config.db.write.failure', App::environment());
			
			// Write the controls
			$this->controls = Form::open(['url' => 'setup/config/db/verify']).
				Form::button('Re-Test', [
					'class'	=> 'btn btn-primary',
					'id'	=> 'next',
					'name'	=> 'next',
					'type'	=> 'submit',
				]).
				Form::close();
		}
	}

	public function postVerify()
	{
		// Set the view
		$this->view = 'setup/config/database';

		// Set the title and header
		$this->title = 'Database Connection Setup';
		$this->header = 'Verify Database Connection <small>Database Connection Setup</small>';

		// Set the step
		$this->data->step = false;

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		try
		{
			// Try to get the migration table
			$hasTable = Schema::hasTable("{$prefix}migrations");

			// Clear the session
			Session::flush();
			
			// Write the message
			$this->data->message = lang('setup.config.db.check.success');
			
			// Write the controls
			$this->controls = HTML::link('setup', 'Back to Setup Center', ['class' => 'btn btn-primary']);
		}
		catch (Exception $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'No such host is known') !== false)
			{
				$this->header = 'Database Host Not Found';
				$this->data->message = lang('setup.config.db.check.nohost');
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				$this->header = 'User/Password Issue';
				$this->data->message = lang('setup.config.db.check.userpass');
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$this->header = 'Database Not Found';
				$this->data->message = lang('setup.config.db.check.dbname', Session::get('dbName'));
			}
			else
			{
				$this->header = 'Unknown Database Issue';
				$this->data->message = lang('setup.config.db.check.gen');
			}
			
			// Write the controls
			$this->controls = HTML::link('setup/config/db/info', 'Start Over', ['class' => 'btn btn-primary']);
		}
	}

}