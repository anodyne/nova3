<?php

return [

	'menus' => [
		['name' => "Public", 'key' => "public"],
		['name' => "Admin", 'key' => "admin"],
	],

	'menuItems' => [
		['menu_id' => 1, 'order' => 0, 'type' => "route", 'link' => "setup.home", 'title' => "Setup Center", 'authentication' => (int) false],
		['menu_id' => 1, 'order' => 1, 'type' => "internal", 'link' => "#", 'title' => "Admin"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 0, 'type' => "page", 'page_id' => 9, 'title' => "Pages"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 1, 'type' => "page", 'page_id' => 26, 'title' => "Menus"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 2, 'type' => "page", 'page_id' => 46, 'title' => "Roles"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 3, 'type' => "page", 'page_id' => 65, 'title' => "Forms"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 4, 'type' => "page", 'page_id' => 111, 'title' => "Users"],

		['menu_id' => 2, 'order' => 0, 'type' => "page", 'page_id' => 99],

		['menu_id' => 2, 'order' => 1, 'type' => "internal", 'link' => "#", 'title' => "Manage"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 0, 'type' => "page", 'page_id' => 9, 'title' => "Pages"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 1, 'type' => "page", 'page_id' => 18, 'title' => "Additional Content"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 2, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 3, 'type' => "page", 'page_id' => 26, 'title' => "Menus"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 4, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 5, 'type' => "page", 'page_id' => 46, 'title' => "Roles"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 6, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 7, 'type' => "page", 'page_id' => 65, 'title' => "Forms"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 8, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 9, 'type' => "page", 'page_id' => 111, 'title' => "Users"],
	],

];
