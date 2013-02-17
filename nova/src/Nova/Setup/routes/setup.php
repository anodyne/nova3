<?php
/**
 * Setup routes
 *
 * These routes handle everything prior to taking action on the database.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Route
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

Route::group(array('prefix' => 'setup'), function()
{
	Route::get('/', function()
	{
		return 'Setup module';
	});

	Route::get('config', function()
	{
		return 'Database config file setup';
	});
});