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

/*
|--------------------------------------------------------------------------
| Citadel Bindings for Sentry
|--------------------------------------------------------------------------
|
| Because of the unique nature of Nova, we have created our own
| implementations of the various Sentry components and wrapped them together
| under the name Citadel. Here, we bind those components to Sentry so they
| get used from the get-go.
|
*/

$app->bind('sentry.hasher', function($app)
{
	return new Nova\Citadel\Hashing\CitadelHasher;
});

$app->bind('sentry.group', function($app)
{
	return new Nova\Citadel\Groups\Provider('AccessRoleModel');
});

$app->bind('sentry.user', function($app)
{
	return new Nova\Citadel\Users\Provider($app['sentry.hasher'], 'UserModel');
});

$app->bind('sentry.throttle', function($app)
{
	return new Nova\Citadel\Throttling\Provider($app['sentry.user'], 'UserSuspendModel');
});