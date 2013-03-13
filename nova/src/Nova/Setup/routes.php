<?php
/**
 * Setup routes
 *
 * The setup routes are separated into different files to keep file sizes down
 * and to separate code into logical groupings.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Route
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

/**
 * Route filter to ensure the right database connection file is in place.
 */
Route::filter('configFileCheck', function()
{
	if ( ! file_exists(APPPATH.'config/'.App::environment().'/database.php'))
	{
		// Only redirect if we aren't on the config page(s)
		if ( ! Request::is('setup/config*'))
		{
			return Redirect::to('setup/config');
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
				//return Redirect::to('login/index/'.Nova\Core\Controller\Login::NOT_ADMIN);
			}
		}
		else
		{
			// No session? Send them away
			//return Redirect::to('login/index/'.Nova\Core\Controller\Login::NOT_LOGGED_IN);
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
	View::addLocation(SRCPATH.'Setup/views');

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

require_once 'routes/setup.php';
require_once 'routes/update.php';
require_once 'routes/install.php';
require_once 'routes/migrate.php';