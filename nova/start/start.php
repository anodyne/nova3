<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Nova\Extensions\Laravel\Application;

$app->redirectIfTrailingSlash();

/*
|--------------------------------------------------------------------------
| Bind Paths
|--------------------------------------------------------------------------
|
| Here we are binding the paths configured in paths.php to the app. You
| should not be changing these here. If you need to change these you
| may do so within the paths.php file and they will be bound here.
|
*/

$app->bindInstallPaths(require NOVAPATH.'start/paths.php');

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name or HTTP host that matches a
| given environment, then we will automatically detect it for you.
|
*/

$env = $app->detectEnvironment(array(

	//'local' => array('localhost', '*.dev', '*.app', 'dev.*'),
	'local' => array('*'),

));

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
	// Get the filesystem
	$filesystem = new Illuminate\Filesystem\Filesystem;

	// Get the cache
	$cache = new Illuminate\Cache\FileStore($filesystem, $app['path.storage'].'/cache');

	return new Nova\Extensions\Laravel\Config\ConfigCascadingFileLoader($filesystem, $cache, false);
	
}, true);

/*
|--------------------------------------------------------------------------
| Load The Nova Helpers
|--------------------------------------------------------------------------
|
| We will load the helpers file to give us access to several functions used
| throughout the system.
|
*/

require NOVAPATH.'start/helpers.php';

/*
|--------------------------------------------------------------------------
| Load The Application
|--------------------------------------------------------------------------
|
| Here we will load the Illuminate application. We'll keep this is in a
| separate location so we can isolate the creation of an application
| from the actual running of the application with a given request.
|
*/

$framework = VENDORPATH.'laravel/framework/src';

require $framework.'/Illuminate/Foundation/start.php';

/*
|--------------------------------------------------------------------------
| Check Cache Directory
|--------------------------------------------------------------------------
|
| Here we check to make sure the cache directory is writable. If it isn't
| we throw an exception since Nova 3 relies heavily on caching to be as
| performant as possible.
|
*/

if ( ! File::isWritable($app['path.storage'].'/cache'))
{
	throw new RuntimeException("cache directory not writable");
}

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;