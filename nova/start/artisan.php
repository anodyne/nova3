<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::add(new Nova\Core\Commands\RefreshRoutes);
Artisan::add(new Nova\Core\Commands\RefreshContent);
Artisan::add(new Nova\Core\Commands\Optimize($app['composer']));