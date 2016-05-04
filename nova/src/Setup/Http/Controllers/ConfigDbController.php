<?php namespace Nova\Setup\Http\Controllers;

use Flash, Input;
use PDO, PDOException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Connectors\Connector;

class ConfigDbController extends BaseController {

	public function info()
	{
		return view('pages.setup.config.db.info');
	}

	public function check(Connector $connector, Filesystem $files)
	{
		if (Input::get('db_name') == "")
		{
			flash()->error("No Database Found", "Please enter a database name to configure your database connection.");
			
			return redirect()->back()->withInput();
		}

		// Set the session variables
		session(['dbDriver' => trim(Input::get('db_driver'))]);
		session(['dbName' => trim(Input::get('db_name'))]);
		session(['dbUser' => trim(Input::get('db_user'))]);
		session(['dbPass' => trim(Input::get('db_password'))]);
		session(['dbHost' => trim(Input::get('db_host'))]);
		session(['prefix' => trim(Input::get('db_prefix'))]);

		// Set the connection parameters
		config(['database.default' => session('dbDriver')]);

		if (session('dbDriver') == 'sqlite')
		{
			// Make sure the database file exists
			if ( ! $files->exists(storage_path().'/database.sqlite'))
			{
				$files->put(storage_path().'/database.sqlite', '');
			}

			config(['database.connections.sqlite.prefix' => session('prefix')]);

			// Build the config array
			$config = [
				'type'		=> config("database.default"),
				'database'	=> config("database.connections.sqlite.database"),
			];
		}
		else
		{
			config([
				"database.connections.{session('dbDriver')}.host" => session('dbHost'),
				"database.connections.{session('dbDriver')}.database" => session('dbName'),
				"database.connections.{session('dbDriver')}.username" => session('dbUser'),
				"database.connections.{session('dbDriver')}.password" => session('dbPass'),
				"database.connections.{session('dbDriver')}.prefix" => session('prefix')
			]);

			// Build the config array
			$config = [
				'type'		=> config("database.default"),
				'host'		=> config("database.connections.{session('dbDriver')}.host"),
				'database'	=> config("database.connections.{session('dbDriver')}.database"),
				'username'	=> config("database.connections.{session('dbDriver')}.username"),
				'password'	=> config("database.connections.{session('dbDriver')}.password"),
			];
		}

		try
		{
			// Build the DSN
			$dsn = (session('dbDriver') == 'sqlite')
				? "sqlite:".config('database.connections.sqlite.database')
				: "{$config['type']}:host={$config['host']};dbname={$config['database']}";

			// Try to connect to the database
			$connection = $connector->createConnection($dsn, $config, $connector->getDefaultOptions());

			return redirect()->route("setup.{$this->setupType}.config.db.write");

		}
		catch (PDOException $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'No such host is known') !== false)
			{
				flash()->error("Database Host Not Found", "The database host you provided couldn't be found. Most of the time, web hosts use `localhost`, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.");
			}
			elseif (stripos($msg, 'could not find driver') !== false)
			{
				flash()->error("PDO Driver Not Found", "Your server doesn't have the necessary PDO driver for connecting to the database. Contact your web host to resolve this issue.");
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				flash()->error("User/Password Issue", "The username and/or password you provided doesn't seem to work. Double check your username and/or password and try again.");
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$dbName = session('dbName');

				flash()->error("Database Not Found", sprintf("A successful connection was made to your database server (which means your username and password are fine) but the database `%s` couldn't be found.\r\n\r\n- Are you sure it exists?\r\n- Do you have permissions to use the `%s` database?\r\n- On some systems the name of your database is prefixed with your username, like `%s_%s`. Could that be the problem?\r\n\r\nIf you're not sure how to setup a database or what your database connection settings are, you should contact your web host.", $dbName, $dbName, session('dbUser'), $dbName));
			}
			else
			{
				flash()->error("Unknown Database Issue", "There was an unidentified error when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again.\r\n\r\n`".$e->getMessage()."`");
			}

			return redirect()->route("setup.{$this->setupType}.config.db")->withInput();
		}
	}

	public function write(Filesystem $files)
	{
		if (session()->has('dbName'))
		{
			// Grab the config writer
			$writer = app('nova.setup.configWriter');

			// Write the database config
			$writer->write('database', [
				"#DB_DRIVER#"	=> session('dbDriver'),
				"#DB_HOST#"		=> session('dbHost'),
				"#DB_DATABASE#"	=> session('dbName'),
				"#DB_USERNAME#"	=> session('dbUser'),
				"#DB_PASSWORD#"	=> session('dbPass'),
				"#DB_PREFIX#"	=> session('prefix'),
			]);

			if ($files->exists(app('path.config').'/database.php'))
			{
				// Flush all the session info
				session()->flush();

				return redirect()->route("setup.{$this->setupType}.config.db.success");
			}

			// Set the flash message
			flash()->error(null, "We couldn't write the database connection file because of your server's settings. Please contact your web host to ensure PHP files can write to the server.");

			return redirect()->route("setup.{$this->setupType}.config.db");
		}

		// Set the flash message
		flash()->warning(null, "There were no database connection details found. Please enter your database connection details and try again.");

		return redirect()->route("setup.{$this->setupType}.config.db");
	}

	public function success()
	{
		return view('pages.setup.config.db.success');
	}

}
