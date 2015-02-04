<?php

$pages = [
	[
		'verb'				=> "GET",
		'name'				=> "home",
		'uri'				=> "/",
		'default_resource'	=> "Nova\\Core\\Game\\Http\\Controllers\\HomeController@home",
		'protected'			=> (int) true,
	],

	[
		'verb'				=> "GET",
		'name'				=> "login",
		'uri'				=> "login",
		'default_resource'	=> "Nova\\Core\\Login\\Http\\Controllers\\LoginController@index",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "POST",
		'name'				=> "login.do",
		'uri'				=> "login",
		'default_resource'	=> "Nova\\Core\\Login\\Http\\Controllers\\LoginController@login",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "GET",
		'name'				=> "logout",
		'uri'				=> "logout",
		'default_resource'	=> "Nova\\Core\\Login\\Http\\Controllers\\LoginController@logout",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "GET",
		'name'				=> "password.email",
		'uri'				=> "password",
		'default_resource'	=> "Nova\\Core\\Login\\Http\\Controllers\\PasswordController@email",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "POST",
		'name'				=> "password.email.send",
		'uri'				=> "password",
		'default_resource'	=> "Nova\\Core\\Login\\Http\\Controllers\\PasswordController@emailReset",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "GET",
		'name'				=> "password.reset",
		'uri'				=> "password/reset/{token}",
		'default_resource'	=> "Nova\\Core\\Login\\Http\\Controllers\\PasswordController@reset",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "POST",
		'name'				=> "password.reset.do",
		'uri'				=> "password/reset",
		'default_resource'	=> "Nova\\Core\\Login\\Http\\Controllers\\PasswordController@resetPassword",
		'protected'			=> (int) true,
	],
];

$collections = [];

$content = [];

$navigation = [];

$data = [
	'pages'			=> $pages,
	'collections'	=> $collections,
	'content'		=> $content,
	'navigation'	=> $navigation,
];

return $data;
