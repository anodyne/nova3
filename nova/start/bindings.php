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

/*
|--------------------------------------------------------------------------
| Register Location Class
|--------------------------------------------------------------------------
|
| We're going to register the Location class with the App container so
| we always have access to it.
|
*/

$app->bind('location', function($app)
{
	return new Nova\Core\Lib\Location(false, false, false);
});