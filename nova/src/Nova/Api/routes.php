<?php
/**
 * API Routes
 *
 * @package		Nova
 * @subpackage	API
 * @category	Route
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

Route::filter('apiAuth', function()
{
    // Test against the presence of Basic Auth credentials
    $creds = array(
        'username' => Request::getUser(),
        'password' => Request::getPassword(),
    );

    if ( ! Auth::attempt($creds))
    {
        return Response::json(array(
            'error'		=> true,
            'message'	=> 'Unauthorized Request'),
            401
        );
    }
});

Route::get('api/info', function()
{
	return Response::json(array(
		'error' => false,
		'message' => array(
			'api_version'	=> '1.0',
			'nova_version'	=> '3.0',
			'nova_url'		=> 'url',
		)),
		201
	);
});

require_once 'routes/logs.php';
require_once 'routes/posts.php';
require_once 'routes/announcements.php';