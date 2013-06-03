<?php

/**
 * Route filter to ensure the right database connection file is in place.
 */
Route::filter('configFileCheck', function()
{
	if ( ! File::exists(APPPATH.'config/'.App::environment().'/database.php'))
	{
		// Only redirect if we aren't on the config page(s)
		if ( ! Request::is('setup/config/db*') and ! Request::is('setup'))
		{
			return Redirect::to('setup');
		}
	}
});

/**
 * Route filter to ensure the person is authorized to be here.
 */
Route::filter('setupAuthorization', function()
{
	if (Utility::installed())
	{
		if (Sentry::check())
		{
			// Not a system administrator? No soup for you!
			if ( ! Sentry::getUser()->isAdmin())
			{
				//return Redirect::to('login/'.Nova\Core\Controllers\Login::NOT_ADMIN);
			}
		}
		else
		{
			// No session? Send them away
			//return Redirect::to('login/'.Nova\Core\Controllers\Login::NOT_LOGGED_IN);
		}
	}
});

/**
 * Setup template execution.
 *
 * @param	object	An object of data to use for the current request
 * @return	View
 */
function setupTemplate($data)
{
	// Add the setup package to the list for this request
	View::addLocation(SRCPATH.'setup/views');

	// Build the structure
	$template = View::make('components/structure/setup');
	$template->title = $data->title;
	$template->javascript = ( ! empty($data->jsView)) ? View::make("components/js/{$data->jsView}") : false;

	// Build the layout
	$template->layout = View::make('components/template/setup');
	$template->layout->label = $data->layout->label;

	// Build the steps indicator
	if ( ! empty($data->steps))
	{
		$template->layout->steps = View::make("components/partial/{$data->steps}");
	}
	else
	{
		$template->layout->steps = false;
	}
	
	// Build the flash message
	if (isset($data->flash))
	{
		$template->layout->flash = View::make('components/partial/flash')
			->with(json_decode(json_encode($data->flash), true));
	}
	else
	{
		$template->layout->flash = false;
	}

	// Build the content
	$template->layout->content = View::make("components/page/{$data->view}")
		->with(json_decode(json_encode($data->content), true));

	// Build the controls
	$template->layout->controls = $data->controls;

	return $template;
}

require 'routes/setup.php';
require 'routes/update.php';
require 'routes/install.php';
require 'routes/migrate.php';