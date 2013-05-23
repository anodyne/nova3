<?php

Route::group(array('prefix' => 'setup/update', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
{
	/**
	 * Nothing here, redirect to the start page.
	 */
	Route::get('/', function()
	{
		return Redirect::to('setup/start');
	});

	/**
	 * Run the update process.
	 */
	Route::post('/', function()
	{
		// Make sure we don't time out
		set_time_limit(0);

		// Get up to the latest migration
		Artisan::call('migrate', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

		// Register
		# TODO: need to figure out how we want to do registration

		return Redirect::to('setup/update/finalize');
	});

	/**
	 * Show page confirming everything is finished.
	 */
	Route::get('finalize', function()
	{
		$data = new stdClass;
		$data->view = 'update/finalize';
		$data->jsView = false;
		$data->title = 'Setup Center';
		$data->layout = new stdClass;
		$data->layout->label = 'Update Nova';
		$data->controls = false;
		$data->steps = 'steps_update';
		$data->content = new stdClass;

		// Set the controls
		$data->controls = HTML::link('/', 'Back to Site', array('class' => 'btn btn-primary'));

		return setupTemplate($data);
	});
});

Route::group(array('prefix' => 'setup/update/rollback', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
{
	/**
	 * Explain what rollback is and provide the start option.
	 */
	Route::get('/', function()
	{
		$data = new stdClass;
		$data->view = 'update/rollback';
		$data->jsView = false;
		$data->title = 'Rollback Nova';
		$data->layout = new stdClass;
		$data->layout->label = 'Rollback Nova';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;
		$data->content->message = false;

		if (version_compare(Config::get('nova.app.version'), '3.0.0', '>'))
		{
			// Set the controls
			$data->controls = HTML::link('setup', "I don't want to do this, get me out of here", array(
				'class' => 'pull-right'
			));
			$data->controls.= Form::open(array('url' => 'setup/update/rollback')).
				Form::button('Rollback', array(
					'class'	=> 'btn btn-danger',
					'id'	=> 'next',
					'name'	=> 'submit',
					'type'	=> 'submit',
				)).
				//Form::token().
				Form::close();
		}
		else
		{
			$data->content->message = '<p class="alert alert-danger">You cannot rollback to a previous version of Nova. <a href="'.URL::to('setup').'">Go back</a></p>';
		}

		return setupTemplate($data);
	});
	
	/**
	 * Do the rollback.
	 */
	Route::post('/', function()
	{
		// Make sure we don't time out
		set_time_limit(0);

		// Get up to the latest migration
		Artisan::call('migrate:rollback', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

		// Register
		# TODO: need to figure out how we want to do registration

		return Redirect::to('setup/update/rollback/finalize');
	});

	/**
	 * Confirm the rollback is done and tell them what to do next.
	 */
	Route::get('finalize', function()
	{
		$data = new stdClass;
		$data->view = 'update/finalize_rollback';
		$data->jsView = false;
		$data->title = 'Rollback Nova';
		$data->layout = new stdClass;
		$data->layout->label = 'Rollback Nova';
		$data->controls = false;
		$data->steps = false;
		$data->content = new stdClass;

		// Set the controls
		$data->controls = HTML::link('setup', "Back to Setup Center", array('class' => 'pull-right'));
		$data->controls.= HTML::link('/', 'Back to Site', array('class' => 'btn btn-primary'));

		return setupTemplate($data);
	});
});