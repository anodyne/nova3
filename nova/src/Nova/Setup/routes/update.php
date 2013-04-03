<?php

Route::group(array('prefix' => 'setup/update'), function()
{
	Route::get('/', function()
	{
		return Redirect::to('setup/start');
	});

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
		$data->controls = Html::link('temp/main/index', 'Back to Site', array('class' => 'btn btn-primary'));

		return setupTemplate($data);
	});
});