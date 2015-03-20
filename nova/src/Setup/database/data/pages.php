<?php

return [
	[
		'name'				=> "Homepage",
		'key'				=> "home",
		'uri'				=> "/",
		'default_resource'	=> "Nova\\Foundation\\Http\\Controllers\\MainController@page",
	],

	[
		'name'				=> "Log In",
		'key'				=> "login",
		'uri'				=> "login",
		'default_resource'	=> "Nova\\Core\\Auth\\Http\\Controllers\\AuthController@getLogin",
	],
	[
		'verb'				=> "POST",
		'name'				=> "Do Log In",
		'key'				=> "login.do",
		'uri'				=> "login",
		'default_resource'	=> "Nova\\Core\\Auth\\Http\\Controllers\\AuthController@postLogin",
	],
	[
		'name'				=> "Log Out",
		'key'				=> "logout",
		'uri'				=> "logout",
		'default_resource'	=> "Nova\\Core\\Auth\\Http\\Controllers\\AuthController@getLogout",
	],
	[
		'name'				=> "Forgot Password",
		'key'				=> "password.email",
		'uri'				=> "password",
		'default_resource'	=> "Nova\\Core\\Auth\\Http\\Controllers\\PasswordController@getEmail",
	],
	[
		'verb'				=> "POST",
		'name'				=> "Send Password Reminder",
		'key'				=> "password.email.send",
		'uri'				=> "password",
		'default_resource'	=> "Nova\\Core\\Auth\\Http\\Controllers\\PasswordController@postEmail",
	],
	[
		'name'				=> "Reset Password",
		'key'				=> "password.reset",
		'uri'				=> "password/reset/{token}",
		'default_resource'	=> "Nova\\Core\\Auth\\Http\\Controllers\\PasswordController@getReset",
	],
	[
		'verb'				=> "POST",
		'name'				=> "Do Password Reset",
		'key'				=> "password.reset.do",
		'uri'				=> "password/reset",
		'default_resource'	=> "Nova\\Core\\Auth\\Http\\Controllers\\PasswordController@postReset",
	],

	[
		'name'				=> "Page Manager",
		'key'				=> "admin.pages",
		'uri'				=> "admin/pages",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@index",
	],
	[
		'name'				=> "Create Page",
		'key'				=> "admin.pages.create",
		'uri'				=> "admin/pages/create",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@create",
	],
	[
		'verb'				=> "POST",
		'name'				=> "Store Page",
		'key'				=> "admin.pages.store",
		'uri'				=> "admin/pages/create",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@store",
	],
	[
		'name'				=> "Edit Page",
		'key'				=> "admin.pages.edit",
		'uri'				=> "admin/pages/{pageId}/edit",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@edit",
	],
	[
		'verb'				=> "PUT",
		'name'				=> "Update Page",
		'key'				=> "admin.pages.update",
		'uri'				=> "admin/pages/{pageId}",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@update",
	],
	[
		'name'				=> "Remove Page Pop-up",
		'key'				=> "admin.pages.remove",
		'uri'				=> "admin/pages/{pageId}/remove",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@remove",
	],
	[
		'verb'				=> "DELETE",
		'name'				=> "Remove Page",
		'key'				=> "admin.pages.destroy",
		'uri'				=> "admin/pages/{pageId}",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@destroy",
	],
	[
		'verb'				=> "POST",
		'name'				=> "Check for Duplicate Page Keys",
		'key'				=> "admin.pages.checkKey",
		'uri'				=> "admin/pages/check-key",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@checkPageKey",
	],
	[
		'verb'				=> "POST",
		'name'				=> "Check for Duplicate Page URIs",
		'key'				=> "admin.pages.checkUri",
		'uri'				=> "admin/pages/check-uri",
		'default_resource'	=> "Nova\\Core\\Pages\\Http\\Controllers\\PageController@checkPageUri",
	],
];
