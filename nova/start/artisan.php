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

Artisan::add(new nova\core\commands\RefreshRoutes);
Artisan::add(new nova\core\commands\RefreshContent);
Artisan::add(new nova\core\commands\Optimize($app['composer']));
Artisan::add(new nova\core\commands\TestCommand);