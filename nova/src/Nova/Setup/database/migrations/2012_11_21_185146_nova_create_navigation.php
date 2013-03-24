<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateNavigation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->integer('group')->nullable();
			$t->integer('order')->nullable();
			$t->text('url');
			$t->string('url_target')->default('onsite');
			$t->string('needs_login')->default('none');
			$t->string('access');
			$t->string('type');
			$t->string('category');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->integer('sim_type')->default(1);
			$t->timestamps();
		});

		// Seed the database
		$this->seed();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('navigation');
	}

	protected function seed()
	{
		$data = array(
			/**
			 * Main Navigation
			 */
			array(
				'name' => 'Main',
				'group' => 0,
				'order' => 0,
				'url' => 'main/index',
				'type' => 'main',
				'category' => 'main'),
			/*array(
				'name' => 'Personnel',
				'group' => 0,
				'order' => 1,
				'url' => 'personnel/index',
				'sim_type' => 1,
				'category' => 'main'),
			array(
				'name' => 'Sim',
				'group' => 0,
				'order' => 2,
				'url' => 'sim/index',
				'sim_type' => 1,
				'category' => 'main'),
			array(
				'name' => 'Wiki',
				'group' => 0,
				'order' => 3,
				'url' => 'wiki/index',
				'sim_type' => 1,
				'category' => 'main',
				'status' => (int) true),
			array(
				'name' => 'Forums',
				'group' => 0,
				'order' => 3,
				'url' => 'forums/index',
				'sim_type' => 1,
				'category' => 'main',
				'status' => (int) true),
			array(
				'name' => 'Search',
				'group' => 0,
				'order' => 4,
				'url' => 'search/index',
				'sim_type' => 1,
				'category' => 'main'),
			*/
			
			/**
			 * Sub Navigation
			 */	
			array(
				'name' => 'Main',
				'group' => 0,
				'order' => 0,
				'url' => 'main/index',
				'type' => 'sub',
				'category' => 'main'),
			/*array(
				'name' => 'Announcements',
				'group' => 0,
				'order' => 1,
				'url' => 'main/announcements',
				'type' => 'sub',
				'category' => 'main'),
			array(
				'name' => 'Contact',
				'group' => 0,
				'order' => 2,
				'url' => 'main/contact',
				'type' => 'sub',
				'category' => 'main'),*/
			array(
				'name' => 'Credits',
				'group' => 0,
				'order' => 3,
				'url' => 'main/credits',
				'type' => 'sub',
				'category' => 'main'),
			array(
				'name' => 'Join',
				'group' => 0,
				'order' => 4,
				'url' => 'main/join',
				'type' => 'sub',
				'category' => 'main'),
			/*array(
				'name' => 'Search',
				'group' => 1,
				'order' => 0,
				'url' => 'search/index',
				'type' => 'sub',
				'category' => 'main'),
			array(
				'name' => 'Manifest',
				'group' => 0,
				'order' => 0,
				'url' => 'personnel/index',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'personnel'),
			array(
				'name' => 'Awards',
				'group' => 0,
				'order' => 2,
				'url' => 'sim/awards',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'personnel'),
			array(
				'name' => 'The Sim',
				'group' => 0,
				'order' => 0,
				'url' => 'sim/index',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Missions',
				'group' => 0,
				'order' => 1,
				'url' => 'sim/missions',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Mission Groups',
				'group' => 0,
				'order' => 2,
				'url' => 'sim/missions/group',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Personal Logs',
				'group' => 0,
				'order' => 3,
				'url' => 'sim/listlogs',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Stats',
				'group' => 0,
				'order' => 4,
				'url' => 'sim/stats',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Awards',
				'group' => 0,
				'order' => 5,
				'url' => 'sim/awards',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Departments',
				'group' => 1,
				'order' => 3,
				'url' => 'sim/departments',
				'sim_type' => 1,
				'type' => 'sub',
				'category' => 'sim'),
				
			array(
				'name' => 'Main Page',
				'group' => 0,
				'order' => 0,
				'url' => 'wiki/index',
				'sim_type' => 1,
				'status' => 1,
				'type' => 'sub',
				'category' => 'wiki'),
			array(
				'name' => 'Recent Changes',
				'group' => 0,
				'order' => 1,
				'url' => 'wiki/recent',
				'sim_type' => 1,
				'status' => 1,
				'type' => 'sub',
				'category' => 'wiki'),
			array(
				'name' => 'Categories',
				'group' => 0,
				'order' => 2,
				'url' => 'wiki/categories',
				'sim_type' => 1,
				'status' => 1,
				'type' => 'sub',
				'category' => 'wiki'),
			array(
				'name' => 'Manage Pages',
				'group' => 1,
				'order' => 0,
				'url' => 'wiki/managepages',
				'sim_type' => 1,
				'status' => 1,
				'type' => 'sub',
				'use_access' => 1,
				'access' => 'wiki/page',
				'needs_login' => 'y',
				'category' => 'wiki'),
			array(
				'name' => 'Manage Categories',
				'group' => 1,
				'order' => 1,
				'url' => 'wiki/managecategories',
				'sim_type' => 1,
				'status' => 1,
				'type' => 'sub',
				'use_access' => 1,
				'access' => 'wiki/categories',
				'needs_login' => 'y',
				'category' => 'wiki'),
			array(
				'name' => 'Create New Page',
				'group' => 2,
				'order' => 0,
				'url' => 'wiki/page',
				'sim_type' => 1,
				'status' => 1,
				'type' => 'sub',
				'use_access' => 1,
				'access' => 'wiki/page',
				'needs_login' => 'y',
				'category' => 'wiki'),
			*/
			
			/**
			 * Admin Main Navigation
			 */
			array(
				'name' => 'Control Panel',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/index',
				'type' => 'admin',
				'category' => 'admin'),
			/*array(
				'name' => 'Messages',
				'group' => 0,
				'order' => 1,
				'type' => 'admin',
				'category' => 'messages',
				'access' => 'messages.read.0'),
			array(
				'name' => 'Writing',
				'group' => 0,
				'order' => 2,
				'type' => 'admin',
				'category' => 'write'),*/
			array(
				'name' => 'Manage',
				'group' => 0,
				'order' => 3,
				'type' => 'admin',
				'category' => 'manage'),
			array(
				'name' => 'Characters &amp; Users',
				'group' => 0,
				'order' => 4,
				'type' => 'admin',
				'category' => 'users'),
			/*array(
				'name' => 'Report Center',
				'group' => 0,
				'order' => 5,
				'url' => 'admin/report/index',
				'type' => 'admin',
				'category' => 'report',
				'access' => 'report.read.1'),*/

			/**
			 * Admin Sub Navigation
			 */
			/*array(
				'name' => 'Writing Control Panel',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/write/index',
				'type' => 'adminsub',
				'category' => 'write'),
			array(
				'name' => 'Mission Post',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/write/post',
				'type' => 'adminsub',
				'category' => 'write',
				'access' => 'post.create.0'),
			array(
				'name' => 'Personal Log',
				'group' => 1,
				'order' => 1,
				'url' => 'admin/write/log',
				'type' => 'adminsub',
				'category' => 'write',
				'access' => 'log.create.0'),
			array(
				'name' => 'Announcement',
				'group' => 1,
				'order' => 2,
				'url' => 'admin/write/announcement',
				'type' => 'adminsub',
				'category' => 'write',
				'access' => 'announcement.create.0'),
			array(
				'name' => 'Write New Message',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/messages/write',
				'type' => 'adminsub',
				'category' => 'messages',
				'access' => 'messages.create.0'),
			array(
				'name' => 'Inbox',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/messages/index',
				'type' => 'adminsub',
				'category' => 'messages',
				'access' => 'messages.read.0'),
			array(
				'name' => 'Sent Messages',
				'group' => 1,
				'order' => 1,
				'url' => 'admin/messages/sent',
				'type' => 'adminsub',
				'category' => 'messages',
				'access' => 'messages.read.0'),*/
			/*array(
				'name' => 'Site',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/site/index',
				'type' => 'adminsub',
				'category' => 'manage',
				'access' => 'settings.read.0'),
			array(
				'name' => 'Data',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/data/index',
				'type' => 'adminsub',
				'category' => 'manage',
				'access' => 'rank.read.0'),*/
			array(
				'name' => 'Forms',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/form/index',
				'type' => 'adminsub',
				'category' => 'manage',
				'access' => 'form.read.0'),
			array(
				'name' => 'Ranks',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/rank/index',
				'type' => 'adminsub',
				'category' => 'manage',
				'access' => 'rank.read.0'),

			array(
				'name' => 'All Characters',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/character/index',
				'type' => 'adminsub',
				'category' => 'users',
				'access' => 'character.read.0'),
			array(
				'name' => 'All Users',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/user/index',
				'type' => 'adminsub',
				'category' => 'users',
				'access' => 'user.read.0'),
			array(
				'name' => 'Application Review',
				'group' => 2,
				'order' => 0,
				'url' => 'admin/application/index',
				'type' => 'adminsub',
				'category' => 'users',
				'access' => ''),
			/*	
			array(
				'name' => 'Settings',
				'group' => 0,
				'order' => 0,
				'url' => 'site/settings',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'site',
				'use_access' => 1,
				'access' => 'site/settings'),
			array(
				'name' => 'Messages &amp; Titles',
				'group' => 0,
				'order' => 1,
				'url' => 'site/messages',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'site',
				'use_access' => 1,
				'access' => 'site/messages'),
			array(
				'name' => 'Menu Items',
				'group' => 0,
				'order' => 2,
				'url' => 'site/menus',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'site',
				'use_access' => 1,
				'access' => 'site/menus'),
			array(
				'name' => 'Access Roles',
				'group' => 0,
				'order' => 3,
				'url' => 'site/roles',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'site',
				'use_access' => 1,
				'access' => 'site/roles'),
			array(
				'name' => 'Sim Types',
				'group' => 2,
				'order' => 0,
				'url' => 'site/simtypes',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'site',
				'use_access' => 1,
				'access' => 'site/simtypes'),
			array(
				'name' => 'Rank Catalogue',
				'group' => 2,
				'order' => 1,
				'url' => 'site/catalogueranks',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'site',
				'use_access' => 1,
				'access' => 'site/catalogueranks'),
			array(
				'name' => 'Skin Catalogue',
				'group' => 2,
				'order' => 2,
				'url' => 'site/catalogueskins',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'site',
				'use_access' => 1,
				'access' => 'site/catalogueskins'),
			array(
				'name' => 'Awards',
				'group' => 0,
				'order' => 0,
				'url' => 'manage/awards',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/awards'),
			array(
				'name' => 'Departments',
				'group' => 0,
				'order' => 1,
				'url' => 'manage/depts',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/depts'),
			array(
				'name' => 'Positions',
				'group' => 0,
				'order' => 2,
				'url' => 'manage/positions',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/positions'),
			array(
				'name' => 'Missions',
				'group' => 1,
				'order' => 0,
				'url' => 'manage/missions',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/missions'),
			array(
				'name' => 'Mission Groups',
				'group' => 1,
				'order' => 1,
				'url' => 'manage/missiongroups',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/missions'),
			array(
				'name' => 'Mission Posts',
				'group' => 1,
				'order' => 2,
				'url' => 'manage/posts',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/posts'),
			array(
				'name' => 'Personal Logs',
				'group' => 1,
				'order' => 3,
				'url' => 'manage/logs',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/logs'),
			array(
				'name' => 'News Items',
				'group' => 1,
				'order' => 4,
				'url' => 'manage/news',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/news'),
			array(
				'name' => 'News Categories',
				'group' => 1,
				'order' => 5,
				'url' => 'manage/newscats',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/newscats'),
			array(
				'name' => 'Comments',
				'group' => 1,
				'order' => 6,
				'url' => 'manage/comments',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/comments'),
			array(
				'name' => 'Upload Images',
				'group' => 3,
				'order' => 0,
				'url' => 'upload/index',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 0),
			array(
				'name' => 'Manage Uploads',
				'group' => 3,
				'order' => 1,
				'url' => 'upload/manage',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'upload/manage'),
			array(
				'name' => 'All Characters',
				'group' => 0,
				'order' => 0,
				'url' => 'characters/index',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'characters',
				'use_access' => 1,
				'access' => 'characters/index'),
			array(
				'name' => 'All NPCs',
				'group' => 0,
				'order' => 1,
				'url' => 'characters/npcs',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'characters',
				'use_access' => 1,
				'access' => 'characters/npcs'),
			array(
				'name' => 'Create Character',
				'group' => 0,
				'order' => 2,
				'url' => 'characters/create',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'characters',
				'use_access' => 1,
				'access' => 'characters/create'),
			array(
				'name' => 'Give/Remove Awards',
				'group' => 1,
				'order' => 1,
				'url' => 'characters/awards',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'characters',
				'use_access' => 1,
				'access' => 'characters/awards'),
			array(
				'name' => 'My Account',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/users/account',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'user',
				'access' => 'user.update.1'),
			array(
				'name' => 'My Bio',
				'group' => 0,
				'order' => 1,
				'url' => 'characters/bio',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'user',
				'use_access' => 1,
				'access' => 'characters/bio'),
			array(
				'name' => 'Site Options',
				'group' => 1,
				'order' => 0,
				'url' => 'user/options',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'user',
				'use_access' => 1,
				'access' => 'user/account'),
			array(
				'name' => 'Request LOA',
				'group' => 0,
				'order' => 1,
				'url' => 'admin/users/status',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'user',
				'access' => 'user.update.1'),
			array(
				'name' => 'Award Nominations',
				'group' => 0,
				'order' => 2,
				'url' => 'admin/users/nominate',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'user',
				'access' => 'user.update.1'),
			array(
				'name' => 'All Users',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/users/index',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'user',
				'access' => 'user.read.0'),
			array(
				'name' => 'Link Characters',
				'group' => 1,
				'order' => 1,
				'url' => 'admin/users/link',
				'sim_type' => 1,
				'type' => 'adminsub',
				'category' => 'user',
				'access' => 'user.update.2'),
			*/
		);

		foreach ($data as $d)
		{
			NavModel::add($d);
		}
	}

}