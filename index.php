<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/nova/start/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let's turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight these users.
|
*/

$app = require_once __DIR__.'/nova/start/start.php';

// Pull in the macros
require APPPATH.'macros.php';

// Constants for URLs
define('BASEURL',	$app->request->root().'/');
define('APPURL',	BASEURL.'app/');
define('NOVAURL',	BASEURL.'nova/');
define('SRCURL',	BASEURL.'nova/src/Nova/');

/*
|--------------------------------------------------------------------------
| PHP 5.4 Check
|--------------------------------------------------------------------------
|
| Make sure we're running at least PHP 5.4.0 or higher, otherwise fail.
|
*/

if (version_compare(PHP_VERSION, '5.4.0', '<'))
{
	throw new RuntimeException("php 5.4 required");
}

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can simply call the run method,
| which will execute the request and send the response back to
| the client's browser allowing them to enjoy the creative
| and wonderful applications we have created for them.
|
*/

// Fire the Nova start event
Event::fire('nova.start');

$app->run();

// Fire the Nova shutdown event
Event::fire('nova.shutdown');

/*
|--------------------------------------------------------------------------
| Shutdown The Application
|--------------------------------------------------------------------------
|
| Once the app has finished running, we will fire off the shutdown events
| so that any final work may be done by the application before we shut
| down the process. This is the last thing to happen to the request.
|
*/

$app->shutdown();