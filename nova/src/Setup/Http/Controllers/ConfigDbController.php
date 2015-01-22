<?php namespace Nova\Setup\Http\Controllers;

use Flash,
	Input,
	Config,
	Schema,
	Session,
	Redirect;
use System;
use PDOException;

class ConfigDbController extends Controller {

	public function info()
	{
		return view('pages.setup.config.db.info');
	}

	public function check()
	{
		// Set the session variables
		Session::put('dbName', trim(Input::get('db_name')));
		Session::put('dbUser', trim(Input::get('db_user')));
		Session::put('dbPass', trim(Input::get('db_password')));
		Session::put('dbHost', trim(Input::get('db_host')));
		Session::put('prefix', trim(Input::get('db_prefix')));

		// Set the connection parameters
		Config::set('database.connections.mysql.host', Session::get('dbHost'));
		Config::set('database.connections.mysql.database', Session::get('dbName'));
		Config::set('database.connections.mysql.username', Session::get('dbUser'));
		Config::set('database.connections.mysql.password', Session::get('dbPass'));
		Config::set('database.connections.mysql.prefix', Session::get('prefix'));

		try
		{
			// Try to get the first system record
			$system = System::first();

			dd($system);

			return Redirect::route('pages.setup.config.db.write');

		}
		catch (PDOException $e)
		{
			$msg = (string) $e->getMessage();

			if (stripos($msg, 'Unknown MySQL server host') !== false)
			{
				$message = "<h4>Database Host Not Found</h4><p>The database host you provided couldn't be found. Most of the time, web hosts use <code>localhost</code>, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.</p>";
			}
			elseif (stripos($msg, 'Access denied for user') !== false)
			{
				$message = "<h4>User/Password Issue</h4><p>The username and/or password you provided doesn't seem to work. Double check your username and/or password and try again.</p>";
			}
			elseif (stripos($msg, 'No database selected') !== false)
			{
				$dbName = Session::get('dbName');

				$message = "<h4>Database Not Found</h4><p>".sprintf("A successful connection was made to your database server (which means your username and password are fine) but the database <code>%s</code> couldn't be found.</p><ul><li>Are you sure it exists?</li><li>Does the user have permission to use the <code>%s</code> database?</li><li>On some systems the name of your database is prefixed with your username, like <code>%s_%s</code>. Could that be the problem?</li></ul><p>If you don't know how to setup a database or your database connection settings, you should contact your web host.", $dbName, $dbName, Session::get('dbUser'), $dbName)."</p>";
			}
			else
			{
				$message = "<h4>Unknown Database Issue</h4><p>There was an unidentified error when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again.</p>";
			}

			Flash::error($message);

			return Redirect::route('setup.config.db')->withInput();
		}
	}

	public function write()
	{
		# code...
	}

	public function verify()
	{
		# code...
	}

}