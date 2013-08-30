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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.login.reset',
		'label'		=> 'Reset Password Header',
		'content'	=> "Reset Password",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset'
	],
	[
		'key'		=> 'header.login.reset_confirm',
		'label'		=> 'Confirm Reset Password Header',
		'content'	=> "Confirm Password Reset",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'reset_confirm'
	],
	[
		'key'		=> 'header.login.logout',
		'label'		=> 'Logout Header',
		'content'	=> "Logout",
		'type'		=> $type,
		'section'	=> 'login',
		'page'		=> 'logout'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.main.credits',
		'label'		=> 'Site Credits Header',
		'content'	=> "Site Credits",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'credits'
	],
	[
		'key'		=> 'header.main.join',
		'label'		=> 'Join Header',
		'content'	=> "Join",
		'type'		=> $type,
		'section'	=> 'main',
		'page'		=> 'join'
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
		'page'		=> 'index'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.admin.routes',
		'label'		=> 'Route Manager Header',
		'content'	=> "Routes Manager",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'routes'
	],
	[
		'key'		=> 'header.admin.routes.create',
		'label'		=> 'Create Route Header',
		'content'	=> "Create New Route",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'routes',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.routes.edit',
		'label'		=> 'Edit Route Header',
		'content'	=> "Edit Route",
		'type'		=> $type,
		'section'	=> 'admin',
		'page'		=> 'routes',
		'mode'		=> 'update'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.admin.form.create',
		'label'		=> 'Create Form Header',
		'content'	=> "Create New Form",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'index',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.form.edit',
		'label'		=> 'Edit Form Header',
		'content'	=> "Edit Form",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'index',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'header.admin.form.fields',
		'label'		=> 'Form Field Management Header',
		'content'	=> "Form Fields",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields'
	],
	[
		'key'		=> 'header.admin.form.fields.create',
		'label'		=> 'Create Form Field Header',
		'content'	=> "Create New Form Field",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.form.fields.edit',
		'label'		=> 'Edit Form Field Header',
		'content'	=> "Edit Form Field",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'fields',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'header.admin.form.sections',
		'label'		=> 'Form Section Management Header',
		'content'	=> "Form Sections",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections'
	],
	[
		'key'		=> 'header.admin.form.sections.create',
		'label'		=> 'Create Form Section Header',
		'content'	=> "Create New Form Section",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.form.sections.edit',
		'label'		=> 'Edit Form Section Header',
		'content'	=> "Edit Form Section",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'sections',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'header.admin.form.tabs',
		'label'		=> 'Form Tab Management Header',
		'content'	=> "Form Tabs",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs'
	],
	[
		'key'		=> 'header.admin.form.tabs.create',
		'label'		=> 'Create Form Tab Header',
		'content'	=> "Create New Form Tab",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.form.tabs.edit',
		'label'		=> 'Edit Form Tab Header',
		'content'	=> "Edit Form Tab",
		'type'		=> $type,
		'section'	=> 'form',
		'page'		=> 'tabs',
		'mode'		=> 'update'
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
		'page'		=> 'view'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.admin.ranks.groups',
		'label'		=> 'Rank Groups Management Header',
		'content'	=> "Rank Groups",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'groups'
	],
	[
		'key'		=> 'header.admin.ranks.info',
		'label'		=> 'Rank Info Management Header',
		'content'	=> "Rank Info",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'info'
	],
	[
		'key'		=> 'header.admin.ranks.manage',
		'label'		=> 'Rank Management Header',
		'content'	=> "Ranks",
		'type'		=> $type,
		'section'	=> 'rank',
		'page'		=> 'manage'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.admin.arc.rules',
		'label'		=> 'ARC Rules Header',
		'content'	=> "Application Review Rules",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'rules'
	],
	[
		'key'		=> 'header.admin.arc.history',
		'label'		=> 'ARC History Header',
		'content'	=> "Application History",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'history'
	],
	[
		'key'		=> 'header.admin.arc.review',
		'label'		=> 'ARC Review Header',
		'content'	=> "Application Review",
		'type'		=> $type,
		'section'	=> 'application',
		'page'		=> 'review'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.admin.role.create',
		'label'		=> 'Create Access Role Header',
		'content'	=> "Create New Access Role",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.role.edit',
		'label'		=> 'Edit Access Role Header',
		'content'	=> "Edit Access Role",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'index',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'header.admin.role.tasks',
		'label'		=> 'Access Role Tasks Header',
		'content'	=> "Access Role Tasks",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks'
	],
	[
		'key'		=> 'header.admin.role.tasks.create',
		'label'		=> 'Create Access Role Task Header',
		'content'	=> "Create New Access Role Task",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.role.tasks.edit',
		'label'		=> 'Edit Access Role Task Header',
		'content'	=> "Edit Access Role Task",
		'type'		=> $type,
		'section'	=> 'role',
		'page'		=> 'tasks',
		'mode'		=> 'update'
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
		'page'		=> 'index'
	],
	[
		'key'		=> 'header.admin.catalog.ranks',
		'label'		=> 'Rank Sets Catalog Header',
		'content'	=> "Rank Sets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks'
	],
	[
		'key'		=> 'header.admin.catalog.ranks.create',
		'label'		=> 'Create Rank Set Catalog Header',
		'content'	=> "Create New Rank Set",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.catalog.ranks.edit',
		'label'		=> 'Edit Rank Set Catalog Header',
		'content'	=> "Edit Rank Set",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'ranks',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'header.admin.catalog.skins',
		'label'		=> 'Skin Catalog Header',
		'content'	=> "Skins",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins'
	],
	[
		'key'		=> 'header.admin.catalog.skins.create',
		'label'		=> 'Create Skin Catalog Header',
		'content'	=> "Create New Skin",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.catalog.skins.edit',
		'label'		=> 'Edit Skin Catalog Header',
		'content'	=> "Edit Skin",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'skins',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'header.admin.catalog.modules',
		'label'		=> 'Modules Catalog Header',
		'content'	=> "Modules",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules'
	],
	[
		'key'		=> 'header.admin.catalog.modules.create',
		'label'		=> 'Create Module Catalog Header',
		'content'	=> "Create New Module",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.catalog.modules.edit',
		'label'		=> 'Edit Module Catalog Header',
		'content'	=> "Edit Module",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'modules',
		'mode'		=> 'update'
	],
	[
		'key'		=> 'header.admin.catalog.widgets',
		'label'		=> 'Widgets Catalog Header',
		'content'	=> "Widgets",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets'
	],
	[
		'key'		=> 'header.admin.catalog.widgets.create',
		'label'		=> 'Create Widget Catalog Header',
		'content'	=> "Create New Widget",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets',
		'mode'		=> 'create'
	],
	[
		'key'		=> 'header.admin.catalog.widgets.edit',
		'label'		=> 'Edit Widget Catalog Header',
		'content'	=> "Edit Widget",
		'type'		=> $type,
		'section'	=> 'catalog',
		'page'		=> 'widgets',
		'mode'		=> 'update'
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
		'page'		=> 'all'
	],
	[
		'key'		=> 'header.admin.user.create',
		'label'		=> 'Create User Header',
		'content'	=> "Create New User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'create'
	],
	[
		'key'		=> 'header.admin.user.edit',
		'label'		=> 'Edit User Header',
		'content'	=> "Edit User",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'edit'
	],
	[
		'key'		=> 'header.admin.user.loa',
		'label'		=> 'User LOA Header',
		'content'	=> "Request LOA",
		'type'		=> $type,
		'section'	=> 'user',
		'page'		=> 'loa'
	],

];