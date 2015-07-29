<?php

return [

	'roles' => [
		['name' => "Game Master"],
		['name' => "Power User"],
		['name' => "Active User"],
		['name' => "Inactive User"],
	],

	'permissions' => [
		['display_name' => "Create Pages", 'name' => "page.create"],
		['display_name' => "Edit Pages", 'name' => "page.edit"],
		['display_name' => "Remove Pages", 'name' => "page.remove"],

		['display_name' => "Create Menus", 'name' => "menu.create"],
		['display_name' => "Edit Menus", 'name' => "menu.edit"],
		['display_name' => "Remove Menus", 'name' => "menu.remove"],

		['display_name' => "Create Access Roles", 'name' => "access.create"],
		['display_name' => "Edit Access Roles", 'name' => "access.edit"],
		['display_name' => "Remove Roles", 'name' => "access.remove"],
	],

	'roleAssociations' => [
		'Game Master' => [1,2,3,4,5,6,7,8,9],
		'Power User' => [],
		'Active User' => [],
		'Inactive User' => [],
	],

];
