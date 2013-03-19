<?php

/*
|--------------------------------------------------------------------------
| Register Config Loader
|--------------------------------------------------------------------------
|
| We need to register a new config loader that'll loop through the
| different directories to get all the config files we need.
|
*/

$app->bind('config.loader', function($app)
{
	$filesystem = new Illuminate\Filesystem\Filesystem;

	return new Nova\Foundation\Config\CascadingFileLoader($filesystem, false);
	
}, true);