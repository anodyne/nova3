<?php namespace Nova\Setup\Controllers;

use DB,
	App,
	File,
	Form,
	HTML,
	Cache,
	Config,
	Schema,
	Artisan,
	Redirect,
	RankCatalogModel,
	SkinCatalogModel,
	ModuleCatalogModel,
	WidgetCatalogModel,
	SetupBaseController;
use Exception;
use Symfony\Component\Finder\Finder;

class SetupController extends SetupBaseController {

	public function getIndex()
	{
		// Set the view
		$this->view = 'setup/index';

		// Set the title and header
		$this->title = "Setup Center";
		$this->header = "Nova Setup";

		// Do some checks to see what we should show
		$installed = (bool) \Setup::installed(false);
		$this->data->db = (bool) File::exists(APPPATH.'config/'.App::environment().'/database.php');
		$this->data->email = (bool) File::exists(APPPATH.'config/'.App::environment().'/mail.php');

		// If the system is installed, kick them forward
		if ($installed)
		{
			return Redirect::to('setup/start');
		}
	}

	public function getStart()
	{
		// Set the views
		$this->view = 'setup/start';
		$this->jsView = 'setup/start_js';

		// Set the title and header
		$this->title = 'Setup Center';
		$this->header = 'Nova Setup';

		// Do some checks to see what we should show
		$installed = (bool) \Setup::installed(false);
		$update = ($installed) ? \Setup::getUpdates() : false;

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
				$this->data->option = 4;
				$this->header = 'Nova Setup Utilities';
				$this->controls = HTML::link('/', 'Back to Site', ['class' => 'pull-right']);
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
			catch (Exception $e)
			{
				/**
				 * The database is empty which means the only thing we can do
				 * is a fresh install of Nova 3.
				 */
				$this->data->option = 1;
				$this->controls = Form::open(['url' => 'setup/install']).
					Form::button('Start Install', [
						'class'	=> 'btn btn-primary',
						'id'	=> 'next',
						'name'	=> 'submit',
						'type'	=> 'submit',
					]).
					Form::token().
					Form::close();
				$this->header = 'Install Nova 3';

				// Pull in the steps indicators
				$this->steps = 'setup/steps_install';
			}
		}
	}

	public function getUninstall()
	{
		// Set the views
		$this->view = 'setup/uninstall';
		$this->jsView = 'setup/uninstall_js';

		// Set the title and header
		$this->title = $this->header = 'Uninstall Nova';

		$this->controls = HTML::link('setup', "I don't want to do this, get me out of here", ['class' => 'pull-right']);
		$this->controls.= Form::open(['url' => 'setup/uninstall']).
			Form::button('Uninstall', [
				'class'	=> 'btn btn-danger',
				'id'	=> 'next',
				'name'	=> 'submit',
				'type'	=> 'submit',
			]).
			Form::token().
			Form::close();
	}
	public function postUninstall()
	{
		// Make sure we don't time out
		set_time_limit(0);

		// Remove the app's session config file
		File::delete(APPPATH.'config/'.App::environment().'/session.php');

		// Remove the cache files
		Cache::forget('nova.installed');
		Cache::forget('nova.routes');

		// Do the QuickInstall removals
		ModuleCatalogModel::uninstallAll();
		RankCatalogModel::uninstallAll();
		SkinCatalogModel::uninstallAll();
		WidgetCatalogModel::uninstallAll();

		// Uninstall Nova
		Artisan::call('migrate:reset');

		return Redirect::to('setup/uninstall/cleanup');
	}
	public function getUninstallCleanup()
	{
		// Set the view
		$this->view = 'processing';

		// Set the title and head
		$this->title = $this->header = 'Uninstall Nova';

		// Drop the sessions and migrations tables
		Schema::drop('sessions');
		Schema::drop('migrations');

		// Remove the cache files
		Cache::forget('nova.installed');
		Cache::forget('nova.routes');

		// Wait for it...
		sleep(2);

		return Redirect::to('setup', 302, [
			'Cache-Control'	=> 'no-cache, no-store, must-revalidate',
			'Pragma'		=> 'no-cache',
			'Expires'		=> 0
		]);
	}

	public function getGenres()
	{
		// Set the views
		$this->view = 'setup/genres';
		$this->jsView = 'setup/genres_js';

		// Set the title and header
		$this->title = $this->header = 'The Genre Panel';

		// Set the controls
		$this->controls = HTML::link('setup', 'Back to Setup Center', ['class' => 'pull-right']);

		// Get the genre info
		$info = Config::get('nova.genres');

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Create a new finder
		$finder = new Finder();

		// Set what we're looking for
		$finder->files()->in(SRCPATH.'Setup/database/genres')->name('*.php');

		// Loop through the files in the genres directory
		foreach ($finder as $f)
		{
			// Drop the extension off the end
			$value = str_replace('.php', '', $f->getRelativePathName());

			if (array_key_exists($value, $info))
			{
				$genres[$value] = [
					'name'		=> $info[$value],
					'installed' => ((bool) Schema::hasTable("{$prefix}departments_{$value}")),
				];
			}
			else
			{
				$additional[$value] = [
					'name'		=> $value,
					'installed' => ((bool) Schema::hasTable("{$prefix}departments_{$value}")),
				];
			}
		}
		
		// Set the genres list
		$this->data->genres = (isset($genres)) ? $genres : false;
		$this->data->additional = (isset($additional)) ? $additional : false;
		
		// Set the loading image
		$this->data->loading = HTML::image('nova/views/design/images/loading.gif', 'Processing');
	}

}