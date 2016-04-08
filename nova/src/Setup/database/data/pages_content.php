<?php

return [
	['type' => 'other', 'key' => 'sim.name', 'value' => 'Nova NextGen'],
	['type' => 'other', 'key' => 'sim.year', 'value' => ''],

	/**
	 * Homepage
	 */
	['page_id' => 1, 'type' => 'header', 'key' => 'home.header', 'value' => "Welcome to the {% content:sim.name %}!"],
	['page_id' => 1, 'type' => 'title', 'key' => 'home.title', 'value' => "Home"],
	['page_id' => 1, 'type' => 'message', 'key' => 'home.message', 'value' => "This is my first message. And here is a {% page:home:link %} to the homepage using the new page compiler engine!"],

	/**
	 * Auth
	 */
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

	/**
	 * Pages
	 */
	['page_id' => 9, 'type' => 'header', 'key' => 'admin.pages.header', 'value' => "Pages"],
	['page_id' => 9, 'type' => 'title', 'key' => 'admin.pages.title', 'value' => "Pages"],
	['page_id' => 9, 'type' => 'message', 'key' => 'admin.pages.message', 'value' => null],
	['page_id' => 10, 'type' => 'header', 'key' => 'admin.pages.create.header', 'value' => "Add Page"],
	['page_id' => 10, 'type' => 'title', 'key' => 'admin.pages.create.title', 'value' => "Add Page"],
	['page_id' => 10, 'type' => 'message', 'key' => 'admin.pages.create.message', 'value' => null],
	['page_id' => 12, 'type' => 'header', 'key' => 'admin.pages.edit.header', 'value' => "Edit Page"],
	['page_id' => 12, 'type' => 'title', 'key' => 'admin.pages.edit.title', 'value' => "Edit Page"],
	['page_id' => 12, 'type' => 'message', 'key' => 'admin.pages.edit.message', 'value' => null],
	['page_id' => 18, 'type' => 'header', 'key' => 'admin.content.header', 'value' => "Additional Page Content"],
	['page_id' => 18, 'type' => 'title', 'key' => 'admin.content.title', 'value' => "Additional Page Content"],
	['page_id' => 18, 'type' => 'message', 'key' => 'admin.content.message', 'value' => null],
	['page_id' => 19, 'type' => 'header', 'key' => 'admin.content.create.header', 'value' => "Add Page Content"],
	['page_id' => 19, 'type' => 'title', 'key' => 'admin.content.create.title', 'value' => "Add Page Content"],
	['page_id' => 19, 'type' => 'message', 'key' => 'admin.content.create.message', 'value' => null],
	['page_id' => 21, 'type' => 'title', 'key' => 'admin.content.edit.title', 'value' => "Edit Page Content"],
	['page_id' => 21, 'type' => 'header', 'key' => 'admin.content.edit.header', 'value' => "Edit Page Content"],
	['page_id' => 21, 'type' => 'message', 'key' => 'admin.content.edit.message', 'value' => null],

	/**
	 * Menus
	 */
	['page_id' => 26, 'type' => 'header', 'key' => 'admin.menus.header', 'value' => "Menus"],
	['page_id' => 26, 'type' => 'title', 'key' => 'admin.menus.title', 'value' => "Menus"],
	['page_id' => 26, 'type' => 'message', 'key' => 'admin.menus.message', 'value' => null],
	['page_id' => 27, 'type' => 'header', 'key' => 'admin.menus.create.header', 'value' => "Add Menu"],
	['page_id' => 27, 'type' => 'title', 'key' => 'admin.menus.create.title', 'value' => "Add Menu"],
	['page_id' => 27, 'type' => 'message', 'key' => 'admin.menus.create.message', 'value' => null],
	['page_id' => 29, 'type' => 'header', 'key' => 'admin.menus.edit.header', 'value' => "Edit Menu"],
	['page_id' => 29, 'type' => 'title', 'key' => 'admin.menus.edit.title', 'value' => "Edit Menu"],
	['page_id' => 29, 'type' => 'message', 'key' => 'admin.menus.edit.message', 'value' => null],
	['page_id' => 35, 'type' => 'header', 'key' => 'admin.menus.pages.header', 'value' => null],
	['page_id' => 35, 'type' => 'title', 'key' => 'admin.menus.pages.title', 'value' => "Pages with this Menu"],
	['page_id' => 35, 'type' => 'message', 'key' => 'admin.menus.pages.message', 'value' => null],
	['page_id' => 37, 'type' => 'header', 'key' => 'admin.menus.items.header', 'value' => null],
	['page_id' => 37, 'type' => 'title', 'key' => 'admin.menus.items.title', 'value' => "Menu Items"],
	['page_id' => 37, 'type' => 'message', 'key' => 'admin.menus.items.message', 'value' => null],
	['page_id' => 38, 'type' => 'header', 'key' => 'admin.menus.items.create.header', 'value' => "Add Menu Item"],
	['page_id' => 38, 'type' => 'title', 'key' => 'admin.menus.items.create.title', 'value' => "Add Menu Item"],
	['page_id' => 38, 'type' => 'message', 'key' => 'admin.menus.items.create.message', 'value' => null],
	['page_id' => 41, 'type' => 'header', 'key' => 'admin.menus.items.edit.header', 'value' => "Edit Menu Item"],
	['page_id' => 41, 'type' => 'title', 'key' => 'admin.menus.items.edit.title', 'value' => "Edit Menu Item"],
	['page_id' => 41, 'type' => 'message', 'key' => 'admin.menus.items.edit.message', 'value' => null],

	/**
	 * Roles
	 */
	['page_id' => 46, 'type' => 'header', 'key' => 'admin.access.roles.header', 'value' => "Roles"],
	['page_id' => 46, 'type' => 'title', 'key' => 'admin.access.roles.title', 'value' => "Roles"],
	['page_id' => 46, 'type' => 'message', 'key' => 'admin.access.roles.message', 'value' => null],
	['page_id' => 47, 'type' => 'header', 'key' => 'admin.access.roles.create.header', 'value' => "Add Role"],
	['page_id' => 47, 'type' => 'title', 'key' => 'admin.access.roles.create.title', 'value' => "Add Role"],
	['page_id' => 47, 'type' => 'message', 'key' => 'admin.access.roles.create.message', 'value' => null],
	['page_id' => 49, 'type' => 'header', 'key' => 'admin.access.roles.edit.header', 'value' => "Edit Role"],
	['page_id' => 49, 'type' => 'title', 'key' => 'admin.access.roles.edit.title', 'value' => "Edit Role"],
	['page_id' => 49, 'type' => 'message', 'key' => 'admin.access.roles.edit.message', 'value' => null],
	
	/**
	 * Permissions
	 */
	['page_id' => 55, 'type' => 'header', 'key' => 'admin.access.permissions.header', 'value' => "Permissions"],
	['page_id' => 55, 'type' => 'title', 'key' => 'admin.access.permissions.title', 'value' => "Permissions"],
	['page_id' => 55, 'type' => 'message', 'key' => 'admin.access.permissions.message', 'value' => null],
	['page_id' => 56, 'type' => 'header', 'key' => 'admin.access.permissions.create.header', 'value' => "Add Permission"],
	['page_id' => 56, 'type' => 'title', 'key' => 'admin.access.permissions.create.title', 'value' => "Add Permission"],
	['page_id' => 56, 'type' => 'message', 'key' => 'admin.access.permissions.create.message', 'value' => null],
	['page_id' => 58, 'type' => 'header', 'key' => 'admin.access.permissions.edit.header', 'value' => "Edit Permission"],
	['page_id' => 58, 'type' => 'title', 'key' => 'admin.access.permissions.edit.title', 'value' => "Edit Permission"],
	['page_id' => 58, 'type' => 'message', 'key' => 'admin.access.permissions.edit.message', 'value' => null],

	/**
	 * Forms
	 */
	['page_id' => 64, 'type' => 'header', 'key' => 'admin.forms.header', 'value' => "Forms"],
	['page_id' => 64, 'type' => 'title', 'key' => 'admin.forms.title', 'value' => "Forms"],
	['page_id' => 64, 'type' => 'message', 'key' => 'admin.forms.message', 'value' => null],
	['page_id' => 65, 'type' => 'header', 'key' => 'admin.forms.create.header', 'value' => "Add Form"],
	['page_id' => 65, 'type' => 'title', 'key' => 'admin.forms.create.title', 'value' => "Add Form"],
	['page_id' => 65, 'type' => 'message', 'key' => 'admin.forms.create.message', 'value' => null],
	['page_id' => 67, 'type' => 'header', 'key' => 'admin.forms.edit.header', 'value' => "Edit Form"],
	['page_id' => 67, 'type' => 'title', 'key' => 'admin.forms.edit.title', 'value' => "Edit Form"],
	['page_id' => 67, 'type' => 'message', 'key' => 'admin.forms.edit.message', 'value' => null],
	['page_id' => 71, 'type' => 'header', 'key' => 'admin.forms.tabs.edit.header', 'value' => null],
	['page_id' => 71, 'type' => 'title', 'key' => 'admin.forms.tabs.edit.title', 'value' => "Form Preview"],
	['page_id' => 71, 'type' => 'message', 'key' => 'admin.forms.tabs.edit.message', 'value' => null],

	['page_id' => 73, 'type' => 'header', 'key' => 'admin.forms.tabs.header', 'value' => null],
	['page_id' => 73, 'type' => 'title', 'key' => 'admin.forms.tabs.title', 'value' => "Form Tabs"],
	['page_id' => 73, 'type' => 'message', 'key' => 'admin.forms.tabs.message', 'value' => null],
	['page_id' => 74, 'type' => 'header', 'key' => 'admin.forms.tabs.create.header', 'value' => "Add Form Tab"],
	['page_id' => 74, 'type' => 'title', 'key' => 'admin.forms.tabs.create.title', 'value' => "Add Form Tab"],
	['page_id' => 74, 'type' => 'message', 'key' => 'admin.forms.tabs.create.message', 'value' => null],
	['page_id' => 76, 'type' => 'header', 'key' => 'admin.forms.tabs.edit.header', 'value' => "Edit Form Tab"],
	['page_id' => 76, 'type' => 'title', 'key' => 'admin.forms.tabs.edit.title', 'value' => "Edit Form Tab"],
	['page_id' => 76, 'type' => 'message', 'key' => 'admin.forms.tabs.edit.message', 'value' => null],

	['page_id' => 82, 'type' => 'header', 'key' => 'admin.forms.sections.header', 'value' => null],
	['page_id' => 82, 'type' => 'title', 'key' => 'admin.forms.sections.title', 'value' => "Form Sections"],
	['page_id' => 82, 'type' => 'message', 'key' => 'admin.forms.sections.message', 'value' => null],
	['page_id' => 83, 'type' => 'header', 'key' => 'admin.forms.sections.create.header', 'value' => "Add Form Section"],
	['page_id' => 83, 'type' => 'title', 'key' => 'admin.forms.sections.create.title', 'value' => "Add Form Section"],
	['page_id' => 83, 'type' => 'message', 'key' => 'admin.forms.sections.create.message', 'value' => null],
	['page_id' => 85, 'type' => 'header', 'key' => 'admin.forms.sections.edit.header', 'value' => "Edit Form Section"],
	['page_id' => 85, 'type' => 'title', 'key' => 'admin.forms.sections.edit.title', 'value' => "Edit Form Section"],
	['page_id' => 85, 'type' => 'message', 'key' => 'admin.forms.sections.edit.message', 'value' => null],

	['page_id' => 90, 'type' => 'header', 'key' => 'admin.forms.fields.header', 'value' => null],
	['page_id' => 90, 'type' => 'title', 'key' => 'admin.forms.fields.title', 'value' => "Form Fields"],
	['page_id' => 90, 'type' => 'message', 'key' => 'admin.forms.fields.message', 'value' => null],
	['page_id' => 91, 'type' => 'header', 'key' => 'admin.forms.fields.create.header', 'value' => "Add Form Field"],
	['page_id' => 91, 'type' => 'title', 'key' => 'admin.forms.fields.create.title', 'value' => "Add Form Field"],
	['page_id' => 91, 'type' => 'message', 'key' => 'admin.forms.fields.create.message', 'value' => null],
	['page_id' => 93, 'type' => 'header', 'key' => 'admin.forms.fields.edit.header', 'value' => "Edit Form Field"],
	['page_id' => 93, 'type' => 'title', 'key' => 'admin.forms.fields.edit.title', 'value' => "Edit Form Field"],
	['page_id' => 93, 'type' => 'message', 'key' => 'admin.forms.fields.edit.message', 'value' => null],

	['page_id' => 98, 'type' => 'header', 'key' => 'admin.forms.formcenter.index.header', 'value' => "Form Center"],
	['page_id' => 98, 'type' => 'title', 'key' => 'admin.forms.formcenter.index.title', 'value' => "Form Center"],
	['page_id' => 98, 'type' => 'message', 'key' => 'admin.forms.formcenter.index.message', 'value' => null],
];
