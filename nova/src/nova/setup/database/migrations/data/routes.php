<?php

return [
	[
		'name'		=> 'main/index',
		'verb'		=> 'get',
		'uri'		=> '/',
		'resource'	=> 'Nova\Core\Controllers\Main@getIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'main/credits',
		'verb'		=> 'get',
		'uri'		=> 'main/credits',
		'resource'	=> 'Nova\Core\Controllers\Main@getCredits',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'main/contact',
		'verb'		=> 'get',
		'uri'		=> 'main/contact',
		'resource'	=> 'Nova\Core\Controllers\Main@getContact',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'main/contact',
		'verb'		=> 'post',
		'uri'		=> 'main/contact',
		'resource'	=> 'Nova\Core\Controllers\Main@postContact',
		'protected'	=> (int) true
	],

	/**
	 * login
	 */
	[
		'name'		=> 'login',
		'verb'		=> 'get',
		'uri'		=> 'login',
		'resource'	=> 'Nova\Core\Controllers\Login@getIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'login',
		'verb'		=> 'post',
		'uri'		=> 'login',
		'resource'	=> 'Nova\Core\Controllers\Login@postIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'login/error',
		'verb'		=> 'get',
		'uri'		=> 'login/error/{error}',
		'resource'	=> 'Nova\Core\Controllers\Login@getIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'login/error',
		'verb'		=> 'post',
		'uri'		=> 'login/error/{error}',
		'resource'	=> 'Nova\Core\Controllers\Login@postIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'login/reset',
		'verb'		=> 'get',
		'uri'		=> 'login/reset',
		'resource'	=> 'Nova\Core\Controllers\Login@getReset',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'login/reset',
		'verb'		=> 'post',
		'uri'		=> 'login/reset',
		'resource'	=> 'Nova\Core\Controllers\Login@postReset',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'login/reset_confirm',
		'verb'		=> 'get',
		'uri'		=> 'login/reset_confirm/{id}/{code}',
		'resource'	=> 'Nova\Core\Controllers\Login@getResetConfirm',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'login/reset_confirm',
		'verb'		=> 'post',
		'uri'		=> 'login/reset_confirm/{id}/{code}',
		'resource'	=> 'Nova\Core\Controllers\Login@postResetConfirm',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'logout',
		'verb'		=> 'get',
		'uri'		=> 'logout',
		'resource'	=> 'Nova\Core\Controllers\Login@getLogout',
		'protected'	=> (int) true
	],

	/**
	 * admin/admin
	 */
	[
		'name'		=> 'admin/index',
		'verb'		=> 'get',
		'uri'		=> 'admin/index',
		'resource'	=> 'Nova\Core\Controllers\Admin\Admin@getIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/error',
		'verb'		=> 'get',
		'uri'		=> 'admin/error/{code}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Admin@getError',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/routes',
		'verb'		=> 'get',
		'uri'		=> 'admin/routes',
		'resource'	=> 'Nova\Core\Controllers\Admin\Admin@getRoutes',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/routes',
		'verb'		=> 'post',
		'uri'		=> 'admin/routes',
		'resource'	=> 'Nova\Core\Controllers\Admin\Admin@postRoutes',
		'protected'	=> (int) true
	],

	/**
	 * admin/form
	 */
	[
		'name'		=> 'admin/form',
		'verb'		=> 'get',
		'uri'		=> 'admin/form/{formKey?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@getIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form',
		'verb'		=> 'post',
		'uri'		=> 'admin/form/{formKey?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@postIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/tabs',
		'verb'		=> 'get',
		'uri'		=> 'admin/form/tabs/{formKey}/{id?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@getTabs',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/tabs',
		'verb'		=> 'post',
		'uri'		=> 'admin/form/tabs/{formKey}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@postTabs',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/sections',
		'verb'		=> 'get',
		'uri'		=> 'admin/form/sections/{formKey}/{id?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@getSections',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/sections',
		'verb'		=> 'post',
		'uri'		=> 'admin/form/sections/{formKey}/{id?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@postSections',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/fields',
		'verb'		=> 'get',
		'uri'		=> 'admin/form/fields/{formKey}/{id?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@getFields',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/fields',
		'verb'		=> 'post',
		'uri'		=> 'admin/form/fields/{formKey}/{id?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Form@postFields',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/view',
		'verb'		=> 'get',
		'uri'		=> 'admin/form/view/{formKey?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\FormViewer@getView',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/form/view/detail',
		'verb'		=> 'get',
		'uri'		=> 'admin/form/view/{formKey}/detail/{id}',
		'resource'	=> 'Nova\Core\Controllers\Admin\FormViewer@getView',
		'protected'	=> (int) true
	],
	
	/**
	 * admin/role
	 */
	[
		'name'		=> 'admin/role',
		'verb'		=> 'get',
		'uri'		=> 'admin/role/{roleID?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Role@getIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/role',
		'verb'		=> 'post',
		'uri'		=> 'admin/role',
		'resource'	=> 'Nova\Core\Controllers\Admin\Role@postIndex',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/role/tasks',
		'verb'		=> 'get',
		'uri'		=> 'admin/role/tasks/{taskID?}',
		'resource'	=> 'Nova\Core\Controllers\Admin\Role@getTasks',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'admin/role/tasks',
		'verb'		=> 'post',
		'uri'		=> 'admin/role/tasks',
		'resource'	=> 'Nova\Core\Controllers\Admin\Role@postTasks',
		'protected'	=> (int) true
	],

	/**
	 * ajax/add
	 */
	[
		'name'		=> 'ajax/add/duplicate_route',
		'verb'		=> 'get',
		'uri'		=> 'ajax/add/duplicate_route/{id}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Add@getRouteDuplicate',
		'protected'	=> (int) true
	],

	/**
	 * ajax/get
	 */
	[
		'name'		=> 'ajax/get/position',
		'verb'		=> 'get',
		'uri'		=> 'ajax/get/position/{id}/{return}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Get@getPosition',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/get/rank',
		'verb'		=> 'get',
		'uri'		=> 'ajax/get/rank/{id}/{return}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Get@getRank',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/get/role_desc',
		'verb'		=> 'get',
		'uri'		=> 'ajax/get/role_desc',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Get@getRoleDesc',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/get/role_inherited_tasks',
		'verb'		=> 'post',
		'uri'		=> 'ajax/get/role_inherited_tasks',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Get@postRoleInheritedTasks',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/get/roles_with_task',
		'verb'		=> 'post',
		'uri'		=> 'ajax/get/roles_with_task/{id}/{format}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Get@postRolesWithTask',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/get/skin_preview',
		'verb'		=> 'get',
		'uri'		=> 'ajax/get/skin_preview/{section}/{location}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Get@getSkinPreview',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/get/users_with_role',
		'verb'		=> 'get',
		'uri'		=> 'ajax/get/users_with_role/{id}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Get@getUsersWithRole',
		'protected'	=> (int) true
	],

	/**
	 * ajax/delete
	 */
	[
		'name'		=> 'ajax/delete/route',
		'verb'		=> 'get',
		'uri'		=> 'ajax/delete/route/{id}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Delete@getRoute',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/delete/form_tab',
		'verb'		=> 'get',
		'uri'		=> 'ajax/delete/form_tab/{id}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Delete@getFormTab',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/delete/form_section',
		'verb'		=> 'get',
		'uri'		=> 'ajax/delete/form_section/{id}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Delete@getFormSection',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/delete/form_field',
		'verb'		=> 'get',
		'uri'		=> 'ajax/delete/form_field/{id}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Delete@getFormField',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/delete/form_value',
		'verb'		=> 'get',
		'uri'		=> 'ajax/delete/form_value/{id}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Delete@getFormValue',
		'protected'	=> (int) true
	],

	/**
	 * ajax/update
	 */
	[
		'name'		=> 'ajax/update/route',
		'verb'		=> 'get',
		'uri'		=> 'ajax/update/route/{id?}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Update@getRoute',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/update/form',
		'verb'		=> 'get',
		'uri'		=> 'ajax/update/form/{key?}',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Update@getForm',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/update/form_tab_order',
		'verb'		=> 'post',
		'uri'		=> 'ajax/update/form_tab_order',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Update@postFormTabOrder',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/update/form_section_order',
		'verb'		=> 'post',
		'uri'		=> 'ajax/update/form_section_order',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Update@postFormSectionOrder',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/update/form_field_order',
		'verb'		=> 'post',
		'uri'		=> 'ajax/update/form_field_order',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Update@postFormFieldOrder',
		'protected'	=> (int) true
	],
	[
		'name'		=> 'ajax/update/form_value_order',
		'verb'		=> 'post',
		'uri'		=> 'ajax/update/form_value_order',
		'resource'	=> 'Nova\Core\Controllers\Ajax\Update@postFormValueOrder',
		'protected'	=> (int) true
	],
];