<?php

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
    $data = array(
        'api_version'   => Config::get('nova.api.version'),
        'nova_version'  => Config::get('nova.app.version'),
        'nova_url'      => str_replace(Request::path(), '', Request::url())
    );

    return Response::json($data, 200);
});

require 'routes/logs.php';
require 'routes/posts.php';
require 'routes/announcements.php';