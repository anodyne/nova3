<?php
/**
 * Application & Route Filters
 *
 * Below you will find the "before" and "after" events for the application
 * which may be used to do any work before or after a request into your
 * application.
 */

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/**
 * CSRF Protection Filter
 *
 * The CSRF filter is responsible for protecting your application against
 * cross-site request forgery attacks. If this special token in a user
 * session does not match the one given in this request, we'll bail.
 */

Route::filter('csrf', function()
{
	if (Session::getToken() != Input::get('csrf_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/**
 * Nova Filters
 *
 * These custom filters are for use throughout Nova to perform various
 * actions.
 *
 * installed - Checks the install status of the system.
 */

Route::filter('installed', function()
{
	// Resolve the environment out of the App container
	$env = App::make('env');

	// Get the path info from the Request object
	$path = Route::getRequest()->getPathInfo();

	// If the config file doesn't exist, bounce over the config setup
	if ( ! file_exists(APPPATH."config/{$env}/database.php"))
	{
		//return Redirect::to('setup/main/config');
	}

	// Get the system install status cache file
	$status = Cache::get('nova_system_installed');

	// If the status is null, we know the cache file doesn't exist
	if ($status === null)
	{
		// Grab the UID
		$uid = SystemModel::getUniqueId();

		// Only cache if we have a UID
		if ( ! empty($uid))
		{
			Cache::forever('nova_system_installed', (int) true);
		}
		else
		{
			// Nothing here, so the system isn't installed
			return Redirect::to('setup/main/index');
		}
	}
});
