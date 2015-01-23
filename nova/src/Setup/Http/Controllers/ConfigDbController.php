<?php namespace Nova\Setup\Http\Controllers;

use Flash,
	Input,
	Redirect;
use System;
use PDOException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Connectors\Connector;

class ConfigDbController extends Controller {

	public function info()
	{
		if (file_exists(app('path.config').'/database.php'))
		{
			return Redirect::route('setup.install.config.mail');
		}

		return view('pages.setup.config.db.info');
	}

	public function check(Connector $connector)
	{
		// Set the session variables
		session(['dbName' => trim(Input::get('db_name'))]);
		session(['dbUser' => trim(Input::get('db_user'))]);
		session(['dbPass' => trim(Input::get('db_password'))]);
		session(['dbHost' => trim(Input::get('db_host'))]);
		session(['prefix' => trim(Input::get('db_prefix'))]);

		// Set the connection parameters
		config(['database.connections.mysql.host' => session('dbHost')]);
		config(['database.connections.mysql.database' => session('dbName')]);
		config(['database.connections.mysql.username' => session('dbUser')]);
		config(['database.connections.mysql.password' => session('dbPass')]);
		config(['database.connections.mysql.prefix' => session('prefix')]);

		try
		{
			// Build the config array
			$config = [
				'type'		=> 'mysql',
				'host'		=> session('dbHost'),
				'database'	=> session('dbName'),
				'username'	=> session('dbUser'),
				'password'	=> session('dbPass'),
			];

			// Build the DSN
			$dsn = "{$config['type']}:dbname={$config['database']};host={$config['host']};";

			// Try to connect to the database
			$connector->createConnection($dsn, $config, $connector->getDefaultOptions());

			return Redirect::route('setup.install.config.db.write');

		}
		catch (PDOException $e)
		{
			if (stripos($msg, 'Unknown MySQL server host') !== false)
			{
				Flash::error("The database host you provided couldn't be found. Most of the time, web hosts use `localhost`, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.", "Database Host Not Found");
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				Flash::error("The username and/or password you provided doesn't seem to work. Double check your username and/or password and try again.", "User/Password Issue");
			}
			elseif (stripos($msg, 'No database selected') !== false)
			{
				$dbName = session('dbName');

				Flash::error(sprintf("A successful connection was made to your database server (which means your username and password are fine) but the database `%s` couldn't be found.\r\n\r\n- Are you sure it exists?\r\n- Does the user have permission to use the `%s` database?\r\n- On some systems the name of your database is prefixed with your username, like `%s_%s`. Could that be the problem?\r\n\r\nIf you don't know how to setup a database or your database connection settings, you should contact your web host.", $dbName, $dbName, session('dbUser'), $dbName), "Database Not Found");
			}
			else
			{
				Flash::error("There was an unidentified error when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again.\r\n\r\n`".$e->getMessage()."`", "Unknown Database Issue");
			}

			return Redirect::route('setup.install.config.db')->withInput();
		}
	}

	public function write(Filesystem $files)
	{
		// Grab the content from the generator
		$content = $files->get(app_path('Setup/generators/database.php'));

		// Setup the replacement dictionary
		$replacements = [
			"#DB_HOST#"		=> session('dbHost'),
			"#DB_DATABASE#"	=> session('dbName'),
			"#DB_USERNAME#"	=> session('dbUser'),
			"#DB_PASSWORD#"	=> session('dbPass'),
			"#DB_PREFIX#"	=> session('prefix'),
		];

		// Swap out the placeholders for the real content
		foreach ($replacements as $placeholder => $replacement)
		{
			$content = str_replace($placeholder, $replacement, $content);
		}

		// Create the file and store the content
		$files->put(app('path.config').'/database.php', $content);

		//return Redirect::route('setup.install.config.db.verify');
	}

	public function verify()
	{
		# code...
	}

}