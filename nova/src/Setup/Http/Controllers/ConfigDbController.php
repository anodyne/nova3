<?php namespace Nova\Setup\Http\Controllers;

use PDO, PDOException;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Connectors\Connector;

class ConfigDbController extends BaseController {

	public function info()
	{
		$prefix = ($this->setupType == 'install') ? 'nova_' : 'nova3_';
		$nova2Prefix = ($this->setupType == 'migrate') ? session('nova2_prefix') : false;

		return view('pages.setup.config.db.info', compact('prefix', 'nova2Prefix'));
	}

	public function check(Request $request, Connector $connector, Filesystem $files)
	{
		if ($request->get('db_name') == "")
		{
			flash()->error("No Database Found", "Please enter a database name to configure your database connection.");
			
			return redirect()->back()->withInput();
		}

		$driver = (trim($request->get('db_driver')) == 'mariadb')
			? 'mysql'
			: trim($request->get('db_driver'));

		// Set the session variables
		session(['dbDriver' => $driver]);
		session(['dbName' => trim($request->get('db_name'))]);
		session(['dbUser' => trim($request->get('db_user'))]);
		session(['dbPass' => trim($request->get('db_password'))]);
		session(['dbHost' => trim($request->get('db_host'))]);
		session(['prefix' => trim($request->get('db_prefix'))]);

		// Set the connection parameters
		config(['database.default' => session('dbDriver')]);

		if (session('dbDriver') == 'sqlite')
		{
			// Make sure the database file exists
			if ( ! $files->exists(storage_path('database.sqlite')))
			{
				$files->put(storage_path('database.sqlite'), '');
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
			$connection = $connector->createConnection(
				$dsn,
				$config,
				$connector->getDefaultOptions()
			);

			// Make sure we have the proper versions
			if (session('dbDriver') == 'mysql') {
				$version = $connection->query('select version()')->fetchColumn();
				$version = mb_substr($version, 0, 6);

				if (version_compare($version, '5.5', '<')) {
					flash()->error("Insufficient Version", config('nova.app.name')." requires that MySQL be running version 5.5 or higher. You're currently running version {$version}. Please contact your host for help with a newer version of MySQL.");

					return redirect()->back();
				}
			}

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
			$writer = app('nova.configWriter');

			$dbConfigValues = [
				"#DB_DRIVER#"	=> session('dbDriver'),
				"#DB_HOST#"		=> session('dbHost'),
				"#DB_DATABASE#"	=> session('dbName'),
				"#DB_USERNAME#"	=> session('dbUser'),
				"#DB_PASSWORD#"	=> session('dbPass'),
				"#DB_PREFIX#"	=> session('prefix'),
			];

			if (session()->has('nova2_dbName'))
			{
				$dbConfigValues = array_merge($dbConfigValues, [
					"#NOVA2_DB_HOST#"		=> session('nova2_dbHost'),
					"#NOVA2_DB_DATABASE#"	=> session('nova2_dbName'),
					"#NOVA2_DB_USERNAME#"	=> session('nova2_dbUser'),
					"#NOVA2_DB_PASSWORD#"	=> session('nova2_dbPass'),
					"#NOVA2_DB_PREFIX#"		=> session('nova2_prefix'),
				]);
			}

			// Write the database config
			if ($this->setupType == 'install')
			{
				$writer->write('database', $dbConfigValues);
			}
			else
			{
				$writer->write('database-nova2', $dbConfigValues, 'database');
			}

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
