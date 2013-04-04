<?php

/**
 * Route includes from around the system.
 */

// Pull in the core routes
require SRCPATH.'Api/routes.php';
require SRCPATH.'Forum/routes.php';
require SRCPATH.'Setup/routes.php';
require SRCPATH.'Wiki/routes.php';

// Get the module list
$modules = Cache::get('nova_module_list', array());

// Loop through the modules and include their route files
foreach ($modules as $m)
{
	if (File::exists(APPPATH."module/{$m}/routes.php"))
	{
		include APPPATH."module/{$m}/routes.php";
	}
}

// Pull in the test routes if we're local
if (App::environment() == 'local')
{
	require SRCPATH.'Core/routes/test.php';
}