<?php

/**
 * Route includes from around the system.
 */

// Pull in the core routes
require_once SRCPATH.'Api/routes.php';
require_once SRCPATH.'Forum/routes.php';
require_once SRCPATH.'Setup/routes.php';
require_once SRCPATH.'Wiki/routes.php';

// Get the module list
$modules = Cache::get('nova_module_list', array());

// Loop through the modules and include their route files
foreach ($modules as $m)
{
	if (file_exists(APPPATH."module/{$m}/routes.php"))
	{
		include_once APPPATH."module/{$m}/routes.php";
	}
}

// Pull in the test routes if we're local
if (App::environment() == 'local')
{
	require_once SRCPATH.'Core/routes/test.php';
}

Route::get('temp/main/index', function()
{
	return 'Temporary main index page.';
});