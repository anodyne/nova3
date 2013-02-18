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
 * Make sure the database config file is in place.
 */
Route::filter('configFileCheck', function()
{
	if ( ! file_exists(APPPATH.'config/'.App::environment().'/database.php'))
	{
		// Only redirect if we aren't on the config page
		if ( ! Request::is('setup/config'))
		{
			return Redirect::to('setup/config');
		}
	}
});

/**
 * Make sure the user is authorized to be here.
 */
Route::filter('authorizedAdmin', function()
{
	if (Utility::installed())
	{
		/*if (Sentry::check())
		{
			// If they aren't a system admin, send them away
			if ( ! Sentry::getUser()->isAdmin())
			{
				//return Redirect::to('login/index/'.\Login\Controller_Login::NOT_ADMIN);
			}
		}
		else
		{
			if (Request::is('setup/utilities/*') or Request::is('setup/*'))
			{
				// No session? Send them away
				//return Redirect::to('login/index/'.\Login\Controller_Login::NOT_LOGGED_IN);
			}
		}*/
	}
});

require_once 'routes/setup.php';
require_once 'routes/update.php';
require_once 'routes/install.php';
require_once 'routes/migrate.php';
require_once 'routes/utilities.php';