<?php

/**
 * Site Content - Headers
 */

$type = 'header';

return [

	/**
	 * Login Headers
	 */
	[
		'key'		=> 'header.login',
		'label'		=> 'Log In Header',
		'content'	=> "Log In",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'index',
		'uri'		=> 'login'
	],
	[
		'key'		=> 'header.login.reset',
		'label'		=> 'Reset Password Header',
		'content'	=> "Reset Password",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset',
		'uri'		=> 'login/reset'
	],
	[
		'key'		=> 'header.login.reset_confirm',
		'label'		=> 'Confirm Reset Password Header',
		'content'	=> "Confirm Password Reset",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset_confirm',
		'uri'		=> 'login/reset_confirm'
	],
	[
		'key'		=> 'header.login.logout',
		'label'		=> 'Logout Header',
		'content'	=> "Logout",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'logout',
		'uri'		=> 'logout'
	],

	/**
	 * Main Headers
	 */
	[
		'key'		=> 'header.main',
		'label'		=> 'Main Page Header',
		'content'	=> "Welcome to Nova!",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'index',
		'uri'		=> 'home'
	],
	[
		'key'		=> 'header.main.credits',
		'label'		=> 'Site Credits Header',
		'content'	=> "Site Credits",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'credits',
		'uri'		=> 'credits'
	],
	[
		'key'		=> 'header.main.join',
		'label'		=> 'Join Header',
		'content'	=> "Join",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'join',
		'uri'		=> 'join'
	],

	/**
	 * Personnel Headers
	 */

	/**
	 * Sim Headers
	 */
	[
		'key'		=> 'header.sim',
		'label'		=> 'Sim Header',
		'content'	=> "The Sim",
		'type'		=> $type,
		'section'	=> 'sim',
		'page'		=> 'index',
		'uri'		=> 'sim'
	],

	/**
	 * admin/main Headers
	 */
	[
		'key'		=> 'header.admin',
		'label'		=> 'ACP Header',
		'content'	=> "Control Panel",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'index',
		'uri'		=> 'admin'
	],
	[
		'key'		=> 'header.admin.routes',
		'label'		=> 'Route Manager Header',
		'content'	=> "Routes Manager",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'routes',
		'uri'		=> 'admin/routes'
	],
	[
		'key'		=> 'header.admin.routes.create',
		'label'		=> 'Create Route Header',
		'content'	=> "Create New Route",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'routes',
		'mode'		=> 'create',
		'uri'		=> 'admin/routes'
	],
	[
		'key'		=> 'header.admin.routes.edit',
		'label'		=> 'Edit Route Header',
		'content'	=> "Edit Route",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'routes',
		'mode'		=> 'update',
		'uri'		=> 'admin/routes'
	],

	/**
	 * admin/form Headers
	 */
	[
		'key'		=> 'header.admin.form',
		'label'		=> 'Form Management Header',
		'content'	=> "Forms",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'index',
		'uri'		=> 'admin/form'
	],
	[
		'key'		=> 'header.admin.form.create',
		'label'		=> 'Create Form Header',
		'content'	=> "Create New Form",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'index',
		'mode'		=> 'create',
		'uri'		=> 'admin/form'
	],
	[
		'key'		=> 'header.admin.form.edit',
		'label'		=> 'Edit Form Header',
		'content'	=> "Edit Form",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'index',
		'mode'		=> 'update',
		'uri'		=> 'admin/form'
	],
	[
		'key'		=> 'header.admin.form.fields',
		'label'		=> 'Form Field Management Header',
		'content'	=> "Form Fields",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'uri'		=> 'admin/form/fields'
	],
	[
		'key'		=> 'header.admin.form.fields.create',
		'label'		=> 'Create Form Field Header',
		'content'	=> "Create New Form Field",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'mode'		=> 'create',
		'uri'		=> 'admin/form/fields'
	],
	[
		'key'		=> 'header.admin.form.fields.edit',
		'label'		=> 'Edit Form Field Header',
		'content'	=> "Edit Form Field",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'mode'		=> 'update',
		'uri'		=> 'admin/form/fields'
	],
	[
		'key'		=> 'header.admin.form.sections',
		'label'		=> 'Form Section Management Header',
		'content'	=> "Form Sections",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'uri'		=> 'admin/form/sections'
	],
	[
		'key'		=> 'header.admin.form.sections.create',
		'label'		=> 'Create Form Section Header',
		'content'	=> "Create New Form Section",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'mode'		=> 'create',
		'uri'		=> 'admin/form/sections'
	],
	[
		'key'		=> 'header.admin.form.sections.edit',
		'label'		=> 'Edit Form Section Header',
		'content'	=> "Edit Form Section",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'mode'		=> 'update',
		'uri'		=> 'admin/form/sections'
	],
	[
		'key'		=> 'header.admin.form.tabs',
		'label'		=> 'Form Tab Management Header',
		'content'	=> "Form Tabs",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'uri'		=> 'admin/form/tabs'
	],
	[
		'key'		=> 'header.admin.form.tabs.create',
		'label'		=> 'Create Form Tab Header',
		'content'	=> "Create New Form Tab",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'mode'		=> 'create',
		'uri'		=> 'admin/form/tabs'
	],
	[
		'key'		=> 'header.admin.form.tabs.edit',
		'label'		=> 'Edit Form Tab Header',
		'content'	=> "Edit Form Tab",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'mode'		=> 'update',
		'uri'		=> 'admin/form/tabs'
	],

	/**
	 * admin/formviewer Headers
	 */
	[
		'key'		=> 'header.admin.formviewer',
		'label'		=> 'Form Viewer Header',
		'content'	=> "Form Viewer",
		'type'		=> $type,
		'section'	=> 'formviewer',
		'page'		=> 'index',
		'uri'		=> 'admin/formviewer'
	],

	/**
	 * admin/rank Headers
	 */
	[
		'key'		=> 'header.admin.ranks',
		'label'		=> 'Ranks Index Header',
		'content'	=> "Ranks",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'index',
		'uri'		=> 'admin/rank'
	],
	[
		'key'		=> 'header.admin.ranks.groups',
		'label'		=> 'Rank Groups Management Header',
		'content'	=> "Rank Groups",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'groups',
		'uri'		=> 'admin/rank/groups'
	],
	[
		'key'		=> 'header.admin.ranks.info',
		'label'		=> 'Rank Info Management Header',
		'content'	=> "Rank Info",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'info',
		'uri'		=> 'admin/rank/info'
	],
	[
		'key'		=> 'header.admin.ranks.manage',
		'label'		=> 'Rank Management Header',
		'content'	=> "Ranks",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'manage',
		'uri'		=> 'admin/rank/manage'
	],

	/**
	 * ARC Headers
	 */
	[
		'key'		=> 'header.admin.arc',
		'label'		=> 'ARC Index Header',
		'content'	=> "Application Review Center",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'index',
		'uri'		=> 'admin/arc'
	],
	[
		'key'		=> 'header.admin.arc.rules',
		'label'		=> 'ARC Rules Header',
		'content'	=> "Application Review Rules",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'rules',
		'uri'		=> 'admin/arc/rules'
	],
	[
		'key'		=> 'header.admin.arc.history',
		'label'		=> 'ARC History Header',
		'content'	=> "Application History",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'history',
		'uri'		=> 'admin/arc/history'
	],
	[
		'key'		=> 'header.admin.arc.review',
		'label'		=> 'ARC Review Header',
		'content'	=> "Application Review",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'review',
		'uri'		=> 'admin/arc/review'
	],

	/**
	 * admin/role Headers
	 */
	[
		'key'		=> 'header.admin.role',
		'label'		=> 'Access Roles Header',
		'content'	=> "Access Roles",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'uri'		=> 'admin/role'
	],
	[
		'key'		=> 'header.admin.role.create',
		'label'		=> 'Create Access Role Header',
		'content'	=> "Create New Access Role",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'mode'		=> 'create',
		'uri'		=> 'admin/role'
	],
	[
		'key'		=> 'header.admin.role.edit',
		'label'		=> 'Edit Access Role Header',
		'content'	=> "Edit Access Role",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'mode'		=> 'update',
		'uri'		=> 'admin/role'
	],
	[
		'key'		=> 'header.admin.role.tasks',
		'label'		=> 'Access Role Tasks Header',
		'content'	=> "Access Role Tasks",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'uri'		=> 'admin/role/tasks'
	],
	[
		'key'		=> 'header.admin.role.tasks.create',
		'label'		=> 'Create Access Role Task Header',
		'content'	=> "Create New Access Role Task",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'mode'		=> 'create',
		'uri'		=> 'admin/role/tasks'
	],
	[
		'key'		=> 'header.admin.role.tasks.edit',
		'label'		=> 'Edit Access Role Task Header',
		'content'	=> "Edit Access Role Task",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'mode'		=> 'update',
		'uri'		=> 'admin/role/tasks'
	],

	/**
	 * admin/catalog Headers
	 */
	[
		'key'		=> 'header.admin.catalog',
		'label'		=> 'Resource Catalogs Header',
		'content'	=> "Resource Catalogs",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'index',
		'uri'		=> 'admin/catalog'
	],
	[
		'key'		=> 'header.admin.catalog.ranks',
		'label'		=> 'Rank Sets Catalog Header',
		'content'	=> "Rank Sets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks',
		'uri'		=> 'admin/catalog/ranks'
	],
	[
		'key'		=> 'header.admin.catalog.ranks.create',
		'label'		=> 'Create Rank Set Catalog Header',
		'content'	=> "Create New Rank Set",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks',
		'mode'		=> 'create',
		'uri'		=> 'admin/catalog/ranks'
	],
	[
		'key'		=> 'header.admin.catalog.ranks.edit',
		'label'		=> 'Edit Rank Set Catalog Header',
		'content'	=> "Edit Rank Set",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks',
		'mode'		=> 'update',
		'uri'		=> 'admin/catalog/ranks'
	],
	[
		'key'		=> 'header.admin.catalog.skins',
		'label'		=> 'Skin Catalog Header',
		'content'	=> "Skins",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins',
		'uri'		=> 'admin/catalog/skins'
	],
	[
		'key'		=> 'header.admin.catalog.skins.create',
		'label'		=> 'Create Skin Catalog Header',
		'content'	=> "Create New Skin",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins',
		'mode'		=> 'create',
		'uri'		=> 'admin/catalog/skins'
	],
	[
		'key'		=> 'header.admin.catalog.skins.edit',
		'label'		=> 'Edit Skin Catalog Header',
		'content'	=> "Edit Skin",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins',
		'mode'		=> 'update',
		'uri'		=> 'admin/catalog/skins'
	],
	[
		'key'		=> 'header.admin.catalog.modules',
		'label'		=> 'Modules Catalog Header',
		'content'	=> "Modules",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules',
		'uri'		=> 'admin/catalog/modules'
	],
	[
		'key'		=> 'header.admin.catalog.modules.create',
		'label'		=> 'Create Module Catalog Header',
		'content'	=> "Create New Module",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules',
		'mode'		=> 'create',
		'uri'		=> 'admin/catalog/modules'
	],
	[
		'key'		=> 'header.admin.catalog.modules.edit',
		'label'		=> 'Edit Module Catalog Header',
		'content'	=> "Edit Module",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules',
		'mode'		=> 'update',
		'uri'		=> 'admin/catalog/modules'
	],
	[
		'key'		=> 'header.admin.catalog.widgets',
		'label'		=> 'Widgets Catalog Header',
		'content'	=> "Widgets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets',
		'uri'		=> 'admin/catalog/widgets'
	],
	[
		'key'		=> 'header.admin.catalog.widgets.create',
		'label'		=> 'Create Widget Catalog Header',
		'content'	=> "Create New Widget",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets',
		'mode'		=> 'create',
		'uri'		=> 'admin/catalog/widgets'
	],
	[
		'key'		=> 'header.admin.catalog.widgets.edit',
		'label'		=> 'Edit Widget Catalog Header',
		'content'	=> "Edit Widget",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets',
		'mode'		=> 'update',
		'uri'		=> 'admin/catalog/widgets'
	],

	/**
	 * admin/user Headers
	 */
	[
		'key'		=> 'header.admin.user.all',
		'label'		=> 'All Users Header',
		'content'	=> "Users",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'users',
		'uri'		=> 'admin/user'
	],
	[
		'key'		=> 'header.admin.user.create',
		'label'		=> 'Create User Header',
		'content'	=> "Create New User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'create',
		'uri'		=> 'admin/user/create'
	],
	[
		'key'		=> 'header.admin.user.edit',
		'label'		=> 'Edit User Header',
		'content'	=> "Edit User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'edit',
		'uri'		=> 'admin/user/edit'
	],
	[
		'key'		=> 'header.admin.user.loa',
		'label'		=> 'User LOA Header',
		'content'	=> "Request LOA",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'loa',
		'uri'		=> 'admin/user/loa'
	],
	[
		'key'		=> 'header.admin.user.upload',
		'label'		=> 'User Image Upload Header',
		'content'	=> "Upload User Image",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'uploadUserImage',
		'uri'		=> 'admin/user/upload'
	],

	/**
	 * admin/manage Headers
	 */
	[
		'key'		=> 'header.admin.manage.content',
		'label'		=> 'Manage Site Content Header',
		'content'	=> "Site Content",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'sitecontent',
		'uri'		=> 'admin/sitecontent'
	],
	[
		'key'		=> 'header.admin.manage.content.create',
		'label'		=> 'Create New Site Content Header',
		'content'	=> "Create New Site Content",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'sitecontent',
		'mode'		=> 'create',
		'uri'		=> 'admin/sitecontent'
	],
	[
		'key'		=> 'header.admin.manage.content.update',
		'label'		=> 'Edit New Site Content Header',
		'content'	=> "Edit Site Content",
		'type'		=> $type,
		'section'	=> 'manage',
		'page'		=> 'sitecontent',
		'mode'		=> 'update',
		'uri'		=> 'admin/sitecontent',
	],

];