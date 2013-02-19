<?php

Route::group(array('prefix' => 'setup', 'before' => 'configFileCheck|setupAuthorization'), function()
{
	Route::get('/', function()
	{
		$data = new stdClass;

		$data->view = 'setup/index';
		$data->jsView = 'setup/index_js';

		$data->title = 'Setup';
		$data->layout = new stdClass;
		$data->layout->label = 'Nova Setup';
		$data->layout->image = 'wand-24x24.png';

		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;

		// Do some checks to see what we should show
		$installed = Utility::installed();
		$update = ($installed) ? Utility::getUpdates() : false;

		if ($installed)
		{
			if (is_object($update))
			{
				/**
				 * Nova is installed and an update is available.
				 */
				$data->content->option = 3;
				$data->controls = '<a href="#" class="pull-right muted" rel="ignoreVersion" data-version="'.$update->version.'">Ignore this version</a>';
				$data->controls.= Form::open('setup/update/index/1').
					Form::button('submit', 'Start Update', array('class' => 'btn', 'id' => 'next')).
					Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()).
					Form::close();
				$data->layout->label = 'Update Nova 3';

				// pull in the steps indicators
				$data->steps = View::make('components/partial/setup_update');
				
				$data->content->update = new stdClass;
				$data->content->update->version = 'Nova '.$update->version;
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
				$data->controls = '<a href="'.URL::to('main/index').'" class="pull-right muted">Back to site</a>';
			}
		}
		else
		{
			// get the prefix
			$prefix = DB::table_prefix();

			/**
			 * If we throw an exception here, it means there's no table for Nova to pull
			 * information from, so the only option is a fresh install. If there is a table
			 * to pull from, then we figure out if they're coming from version 1 or version
			 * 2 and take the appropriate action.
			 */
			try {
				// get the information from the database
				$version = DB::query("SELECT * FROM ${prefix}system_info WHERE sys_id = 1")
					->as_object()
					->execute()
					->current()
					->sys_version_major;

				// set the option
				$data->content->option = ((int) $version == 2) ? 2 : 5;

				// nova 2 means they can do the upgrade
				if ($data->content->option == 2)
				{
					$data->controls = '<a href="'.URL::to('setup/install').'" class="pull-right muted">I\'d like to do a Fresh Install instead</a>';
					$data->controls.= Form::open('setup/upgrade/index/1').
						Form::button('submit', 'Start Upgrade', array('class' => 'btn', 'id' => 'next')).
						Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()).
						Form::close();
					$data->layout->label = 'Upgrade From Nova 2';

					// pull in the steps indicators
					$data->steps = View::make('components/partial/setup_upgrade');
				}
				
				// nova 1 means they can't do the upgrade
				if ($data->content->option == 5)
				{
					$data->controls = '<a href="'.URL::to('setup/install').'" class="pull-right muted">I\'d like to do a Fresh Install instead</a>';
					$data->layout->label = 'Unable to Upgrade Nova';
					$data->layout->image = 'cross-24x24.png';
				}
			}
			catch (Database_Exception $e)
			{
				/**
				 * The database is empty which means the only thing we can do
				 * is a fresh install of Nova 3.
				 */
				$data->content->option = 1;
				$data->controls = Form::open('setup/install/index/1').
					Form::button('submit', 'Start Install', array('class' => 'btn', 'id' => 'next')).
					Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()).
					Form::close();
				$data->layout->label = 'Install Nova 3';

				// pull in the steps indicators
				$data->steps = View::make('components/partial/setup_install');
			}
		}

		return setupTemplate($data);
	});

	Route::get('config', function()
	{
		return 'Database config file setup';
	});
});