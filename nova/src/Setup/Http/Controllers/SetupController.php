<?php namespace Nova\Setup\Http\Controllers;

use stdClass;
use Redirect;
use Illuminate\Database\QueryException;

class SetupController extends Controller {

	public function index()
	{
		// Grab the setup service
		$setup = app('nova.setup');

		// Is Nova installed?
		if ($setup->isInstalled())
		{
			return Redirect::route('setup.start');
		}

		// Do some checks to see what we should show
		$db = $setup->isConfigured('db');
		$email = $setup->isConfigured('mail');

		return view('pages.setup.index', compact('db', 'email'));
	}

	public function start()
	{
		/*// Set the views
		$this->view = 'setup/start';
		$this->jsView = 'setup/start_js';

		// Set the title and header
		$this->title = 'Setup Center';
		$this->header = 'Nova Setup';

		// Do some checks to see what we should show
		$installed = (bool) \Setup::installed(false);
		$update = ($installed) ? \Setup::getUpdates() : false;*/

		$installed = false;
		$update = false;

		if ($installed)
		{
			if (is_object($update))
			{
				/**
				 * Nova is installed and an update is available.
				 */
				$this->data->option = 3;
				$this->header = 'Update Nova 3';
				$this->controls = HTML::link('#', 'Ignore this version', [
					'class' => 'pull-right js-ignoreVersion',
					'data-version' => $update->version,
				]);
				$this->controls.= Form::open(['url' => 'setup/update']).
					Form::button('Start Update', [
						'class'	=> 'btn btn-primary',
						'id'	=> 'next',
						'name'	=> 'submit',
						'type'	=> 'submit',
					]).
					Form::token().
					Form::close();

				// Pull in the steps indicators
				$this->steps = 'setup/steps_update';

				// Send the update information over
				$this->data->update = new stdClass;
				$this->data->update->version = "Nova {$update->version}";
				$this->data->update->description = $update->notes;
			}
			else
			{
				/**
				 * Nova is installed and there are no updates available. Show the
				 * admin the list of utilities they can use.
				 */
				$view = 'utilities';
			}
		}
		else
		{
			// Get the prefix
			$prefix = \DB::getTablePrefix();

			/**
			 * If we throw an exception here, it means there's no table for Nova
			 * to pull information from, so the only option is a fresh install.
			 * If there is a table to pull from, then we figure out if they're 
			 * coming from version 1 or version 2 and take the appropriate action.
			 */
			try
			{
				// Get the information from the database
				$version = \DB::table('system_info')
					->where('sys_id', 1)
					->first()
					->sys_version_major;

				// Set the option
				$this->data->option = ((int) $version == 2) ? 2 : 5;

				// Nova 2 means they can do the migration
				if ($this->data->option == 2)
				{
					$this->controls = HTML::link('setup/install', "I'd like to do a Fresh Install", [
						'class' => 'pull-right',
					]);
					$this->controls.= Form::open(['url' => 'setup/migrate']).
						Form::button('Start Migration', [
							'class'	=> 'btn btn-primary',
							'id'	=> 'next',
							'name'	=> 'submit',
							'type'	=> 'submit',
						]).
						Form::token().
						Form::close();
					$this->header = 'Migrate From Nova 2';

					// Pull in the steps indicators
					$this->steps = 'setup/steps_migrate';
				}
				
				// Nova 1 means they can't do the migration
				if ($this->data->option == 5)
				{
					$this->controls = HTML::link('setup/install', "I'd like to do a Fresh Install", [
						'class' => 'pull-right',
					]);
					$this->header = 'Unable to Migrate to Nova 3';
				}
			}
			catch (QueryException $e)
			{
				/**
				 * The database is empty which means the only thing we can do
				 * is a fresh install of Nova 3.
				 */
				$view = 'install';
			}
		}

		return view("pages.setup.start.{$view}");
	}

}
