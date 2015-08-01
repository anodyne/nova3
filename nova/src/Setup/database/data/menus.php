<?php

return [

	'menus' => [
		['name' => "Main", 'key' => "main"],
		['name' => "Admin", 'key' => "admin"],
	],

	'menuItems' => [
		['menu_id' => 1, 'order' => 0, 'type' => "route", 'link' => "setup.home", 'title' => "Setup Center"],
		['menu_id' => 1, 'order' => 1, 'type' => "internal", 'link' => "#", 'title' => "Admin"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 0, 'type' => "page", 'page_id' => 9],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 1, 'type' => "page", 'page_id' => 18, 'title' => "Additional Page Content"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 2, 'type' => "divider"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 3, 'type' => "page", 'page_id' => 26, 'title' => "Menus"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 4, 'type' => "divider"],
		['menu_id' => 1, 'parent_id' => 2, 'order' => 5, 'type' => "page", 'page_id' => 46, 'title' => "Access Roles"],

		['menu_id' => 2, 'order' => 0, 'type' => "internal", 'link' => "#", 'title' => "Manage"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 0, 'type' => "page", 'page_id' => 9],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 1, 'type' => "page", 'page_id' => 18, 'title' => "Additional Page Content"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 2, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 3, 'type' => "page", 'page_id' => 26, 'title' => "Menus"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 4, 'type' => "divider"],
		['menu_id' => 2, 'parent_id' => 9, 'order' => 5, 'type' => "page", 'page_id' => 46, 'title' => "Access Roles"],
	],

];
