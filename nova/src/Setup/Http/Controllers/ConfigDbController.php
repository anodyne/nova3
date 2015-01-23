<?php namespace Nova\Setup\Http\Controllers;

use Flash,
	Input,
	Redirect;
use PDO, PDOException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Connectors\Connector;

class ConfigDbController extends Controller {

	public function info()
	{
		return view('pages.setup.config.db.info');
	}

	public function check(Connector $connector)
	{
		if (Input::get('db_name') == "")
		{
			Flash::error("Please enter a database name to configure your database connection.", "No Database Found");

			return Redirect::back()->withInput();
		}

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
				'host'		=> config("database.connections.mysql.host"),
				'database'	=> config("database.connections.mysql.database"),
				'username'	=> config("database.connections.mysql.username"),
				'password'	=> config("database.connections.mysql.password"),
			];

			// Build the DSN
			$dsn = "{$config['type']}:host={$config['host']};dbname={$config['database']}";

			// Try to connect to the database
			$connection = $connector->createConnection($dsn, $config, $connector->getDefaultOptions());

			return Redirect::route("setup.{$this->setupType}.config.db.write");

		}
		catch (PDOException $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'No such host is known') !== false)
			{
				Flash::error("The database host you provided couldn't be found. Most of the time, web hosts use `localhost`, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.", "Database Host Not Found");
			}
			elseif (stripos($msg, 'could not find driver') !== false)
			{
				Flash::error("Your server doesn't have the necessary PDO driver for connecting to the database. Contact your web host to resolve this issue.", "PDO Driver Not Found");
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				Flash::error("The username and/or password you provided doesn't seem to work. Double check your username and/or password and try again.", "User/Password Issue");
			}
			elseif (stripos($msg, 'Unknown database') !== false)
			{
				$dbName = session('dbName');

				Flash::error(sprintf("A successful connection was made to your database server (which means your username and password are fine) but the database `%s` couldn't be found.\r\n\r\n- Are you sure it exists?\r\n- Does the user have permission to use the `%s` database?\r\n- On some systems the name of your database is prefixed with your username, like `%s_%s`. Could that be the problem?\r\n\r\nIf you don't know how to setup a database or your database connection settings, you should contact your web host.", $dbName, $dbName, session('dbUser'), $dbName), "Database Not Found");
			}
			else
			{
				Flash::error("There was an unidentified error when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again.\r\n\r\n`".$e->getMessage()."`", "Unknown Database Issue");
			}

			return Redirect::route("setup.{$this->setupType}.config.db")->withInput();
		}
	}

	public function write(Filesystem $files)
	{
		if (session()->has('dbName'))
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

			if ($files->exists(app('path.config').'/database.php'))
			{
				// Flush all the session info
				session()->flush();

				return Redirect::route("setup.{$this->setupType}.config.db.success");
			}

			// Set the flash message
			Flash::error("We couldn't write the database connection file because of your server's settings. Please contact your web host to ensure PHP files can write to the server.");

			return Redirect::route("setup.{$this->setupType}.config.db");
		}

		// Set the flash message
		Flash::warning("There were no database connection details found. Please enter your database connection details and try again.");

		return Redirect::route("setup.{$this->setupType}.config.db");
	}

	public function success()
	{
		return view('pages.setup.config.db.success');
	}

}
