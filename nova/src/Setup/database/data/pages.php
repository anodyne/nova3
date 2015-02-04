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
		'default_resource'	=> "Nova\\Core\\Login\\LoginController@index",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "POST",
		'name'				=> "login.do",
		'uri'				=> "login",
		'default_resource'	=> "Nova\\Core\\Login\\LoginController@login",
		'protected'			=> (int) true,
	],
	[
		'verb'				=> "GET",
		'name'				=> "logout",
		'uri'				=> "logout",
		'default_resource'	=> "Nova\\Core\\Login\\LoginController@logout",
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
