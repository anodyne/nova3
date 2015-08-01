<?php

return [
	['page_id' => 1, 'type' => 'header', 'key' => 'home.header', 'value' => "Welcome to the {% setting:sim_name %}!"],
	['page_id' => 1, 'type' => 'title', 'key' => 'home.title', 'value' => "Home"],
	['page_id' => 1, 'type' => 'message', 'key' => 'home.message', 'value' => "This is my first message. And here is a {% page:home:link %} to the homepage using the new page compiler engine!"],

	['page_id' => 2, 'type' => 'header', 'key' => 'login.header', 'value' => "Log In"],
	['page_id' => 2, 'type' => 'title', 'key' => 'login.title', 'value' => "Log In"],
	['page_id' => 2, 'type' => 'message', 'key' => 'login.message', 'value' => null],
	['page_id' => 4, 'type' => 'header', 'key' => 'logout.header', 'value' => "Log Out"],
	['page_id' => 4, 'type' => 'title', 'key' => 'logout.title', 'value' => "Log Out"],
	['page_id' => 4, 'type' => 'message', 'key' => 'logout.message', 'value' => null],

	['page_id' => 5, 'type' => 'header', 'key' => 'password.remind.header', 'value' => "Send Password Reminder"],
	['page_id' => 5, 'type' => 'title', 'key' => 'password.remind.title', 'value' => "Send Password Reminder"],
	['page_id' => 5, 'type' => 'message', 'key' => 'password.remind.message', 'value' => null],
	['page_id' => 7, 'type' => 'header', 'key' => 'password.reset.header', 'value' => "Reset Password"],
	['page_id' => 7, 'type' => 'title', 'key' => 'password.reset.title', 'value' => "Reset Password"],
	['page_id' => 7, 'type' => 'message', 'key' => 'password.reset.message', 'value' => null],

	['page_id' => 9, 'type' => 'header', 'key' => 'admin.pages.header', 'value' => "Page Manager"],
	['page_id' => 9, 'type' => 'title', 'key' => 'admin.pages.title', 'value' => "Page Manager"],
	['page_id' => 9, 'type' => 'message', 'key' => 'admin.pages.message', 'value' => null],
	['page_id' => 10, 'type' => 'header', 'key' => 'admin.pages.create.header', 'value' => "Add Page"],
	['page_id' => 10, 'type' => 'title', 'key' => 'admin.pages.create.title', 'value' => "Add Page"],
	['page_id' => 10, 'type' => 'message', 'key' => 'admin.pages.create.message', 'value' => null],
	['page_id' => 12, 'type' => 'header', 'key' => 'admin.pages.edit.header', 'value' => "Edit Page"],
	['page_id' => 12, 'type' => 'title', 'key' => 'admin.pages.edit.title', 'value' => "Edit Page"],
	['page_id' => 12, 'type' => 'message', 'key' => 'admin.pages.edit.message', 'value' => null],

	['page_id' => 18, 'type' => 'header', 'key' => 'admin.content.header', 'value' => "Page Content Manager"],
	['page_id' => 18, 'type' => 'title', 'key' => 'admin.content.title', 'value' => "Page Content Manager"],
	['page_id' => 18, 'type' => 'message', 'key' => 'admin.content.message', 'value' => null],
	['page_id' => 19, 'type' => 'header', 'key' => 'admin.content.create.header', 'value' => "Add Page Content"],
	['page_id' => 19, 'type' => 'title', 'key' => 'admin.content.create.title', 'value' => "Add Page Content"],
	['page_id' => 19, 'type' => 'message', 'key' => 'admin.content.create.message', 'value' => null],
	['page_id' => 21, 'type' => 'title', 'key' => 'admin.content.edit.title', 'value' => "Edit Page Content"],
	['page_id' => 21, 'type' => 'header', 'key' => 'admin.content.edit.header', 'value' => "Edit Page Content"],
	['page_id' => 21, 'type' => 'message', 'key' => 'admin.content.edit.message', 'value' => null],

	['page_id' => 26, 'type' => 'header', 'key' => 'admin.menus.header', 'value' => "Menu Manager"],
	['page_id' => 26, 'type' => 'title', 'key' => 'admin.menus.title', 'value' => "Menu Manager"],
	['page_id' => 26, 'type' => 'message', 'key' => 'admin.menus.message', 'value' => null],
	['page_id' => 27, 'type' => 'header', 'key' => 'admin.menus.create.header', 'value' => "Add Menu"],
	['page_id' => 27, 'type' => 'title', 'key' => 'admin.menus.create.title', 'value' => "Add Menu"],
	['page_id' => 27, 'type' => 'message', 'key' => 'admin.menus.create.message', 'value' => null],
	['page_id' => 29, 'type' => 'header', 'key' => 'admin.menus.edit.header', 'value' => "Edit Menu"],
	['page_id' => 29, 'type' => 'title', 'key' => 'admin.menus.edit.title', 'value' => "Edit Menu"],
	['page_id' => 29, 'type' => 'message', 'key' => 'admin.menus.edit.message', 'value' => null],
	['page_id' => 35, 'type' => 'header', 'key' => 'admin.menus.pages.header', 'value' => null],
	['page_id' => 35, 'type' => 'title', 'key' => 'admin.menus.pages.title', 'value' => "Manage Pages with this Menu"],
	['page_id' => 35, 'type' => 'message', 'key' => 'admin.menus.pages.message', 'value' => null],

	['page_id' => 37, 'type' => 'header', 'key' => 'admin.menus.items.header', 'value' => null],
	['page_id' => 37, 'type' => 'title', 'key' => 'admin.menus.items.title', 'value' => "Manage Menu Items"],
	['page_id' => 37, 'type' => 'message', 'key' => 'admin.menus.items.message', 'value' => null],
	['page_id' => 38, 'type' => 'header', 'key' => 'admin.menus.items.create.header', 'value' => "Add Menu Item"],
	['page_id' => 38, 'type' => 'title', 'key' => 'admin.menus.items.create.title', 'value' => "Add Menu Item"],
	['page_id' => 38, 'type' => 'message', 'key' => 'admin.menus.items.create.message', 'value' => null],
	['page_id' => 41, 'type' => 'header', 'key' => 'admin.menus.items.edit.header', 'value' => "Edit Menu Item"],
	['page_id' => 41, 'type' => 'title', 'key' => 'admin.menus.items.edit.title', 'value' => "Edit Menu Item"],
	['page_id' => 41, 'type' => 'message', 'key' => 'admin.menus.items.edit.message', 'value' => null],

	['page_id' => 46, 'type' => 'header', 'key' => 'admin.access.roles.header', 'value' => "Manage Access Roles"],
	['page_id' => 46, 'type' => 'title', 'key' => 'admin.access.roles.title', 'value' => "Manage Access Roles"],
	['page_id' => 46, 'type' => 'message', 'key' => 'admin.access.roles.message', 'value' => null],
	['page_id' => 47, 'type' => 'header', 'key' => 'admin.access.roles.create.header', 'value' => "Add Access Role"],
	['page_id' => 47, 'type' => 'title', 'key' => 'admin.access.roles.create.title', 'value' => "Add Access Role"],
	['page_id' => 47, 'type' => 'message', 'key' => 'admin.access.roles.create.message', 'value' => null],
	['page_id' => 49, 'type' => 'header', 'key' => 'admin.access.roles.edit.header', 'value' => "Edit Access Role"],
	['page_id' => 49, 'type' => 'title', 'key' => 'admin.access.roles.edit.title', 'value' => "Edit Access Role"],
	['page_id' => 49, 'type' => 'message', 'key' => 'admin.access.roles.edit.message', 'value' => null],
	['page_id' => 53, 'type' => 'header', 'key' => 'admin.access.permissions.header', 'value' => "Manage Access Role Permissions"],
	['page_id' => 53, 'type' => 'title', 'key' => 'admin.access.permissions.title', 'value' => "Manage Access Role Permissions"],
	['page_id' => 53, 'type' => 'message', 'key' => 'admin.access.permissions.message', 'value' => null],
	['page_id' => 54, 'type' => 'header', 'key' => 'admin.access.permissions.create.header', 'value' => "Add Access Role Permission"],
	['page_id' => 54, 'type' => 'title', 'key' => 'admin.access.permissions.create.title', 'value' => "Add Access Role Permission"],
	['page_id' => 54, 'type' => 'message', 'key' => 'admin.access.permissions.create.message', 'value' => null],
	['page_id' => 56, 'type' => 'header', 'key' => 'admin.access.permissions.edit.header', 'value' => "Edit Access Role Permission"],
	['page_id' => 56, 'type' => 'title', 'key' => 'admin.access.permissions.edit.title', 'value' => "Edit Access Role Permission"],
	['page_id' => 56, 'type' => 'message', 'key' => 'admin.access.permissions.edit.message', 'value' => null],
];
