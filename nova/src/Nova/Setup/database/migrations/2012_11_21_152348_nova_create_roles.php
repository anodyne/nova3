<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->text('desc')->nullable();
			$t->text('inherits')->nullable();
		});

		Schema::create('roles_tasks', function($t)
		{
			$t->increments('id');
			$t->integer('role_id');
			$t->integer('task_id');
		});

		Schema::create('tasks', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('desc')->nullable();
			$t->string('component', 100);
			$t->string('action', 11)->default('read');
			$t->boolean('level')->default(0);
			$t->text('dependencies')->nullable();
		});

		// Seed the tables
		$this->seed();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
		Schema::drop('roles_tasks');
		Schema::drop('tasks');
	}

	protected function seed()
	{
		$this->seedRoles();
		$this->seedRoleTasks();
		$this->seedTasks();
	}

	protected function seedRoles()
	{
		$data = array(
			array(
				'name' => 'Inactive User',
				'desc' => "Inactive users have no privileges within the system. This role is automatically assigned to any user with who has been retired.",
				'inherits' => ''),
			array(
				'name' => 'User',
				'desc' => "Every user in the system starts with these permissions. This role is automatically assigned to any user who is not retired.",
				'inherits' => ''),
			array(
				'name' => 'Active User',
				'desc' => "Every active user in the system has these permissions.",
				'inherits' => '2'),
			array(
				'name' => 'Power User',
				'desc' => "Power users are given more access to pieces of the system to help them assist the game master as necessary.",
				'inherits' => '2,3'),
			array(
				'name' => 'Administrator',
				'desc' => "Like power users, administrators are given higher permissions to the system to help them assist the game master as necessary.",
				'inherits' => '2,3,4'),
			array(
				'name' => 'System Administrator',
				'desc' => "System administrators have complete control over the system. This role should only be assigned to a select few individuals who are trusted to run the game.",
				'inherits' => '2,3,4,5'),
		);

		foreach ($data as $value)
		{
			AccessRole::add($value);
		}
	}

	protected function seedRoleTasks()
	{
		$data = array(
			2 => array(1, 2, 3, 6),
			3 => array(14, 11, 18, 23, 33, 9, 20, 25, 88, 90, 37),
			4 => array(91, 12, 15, 28, 38),
			5 => array(21, 26, 31, 92, 94, 16, 17, 13, 7, 35, 36, 39),
			6 => array(4, 5, 8, 10, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 89),
		);

		foreach ($data as $key => $value)
		{
			foreach ($value as $task)
			{
				DB::table('roles_tasks')->insert(array('role_id' => $key, 'task_id' => $task));
			}
		}
	}

	protected function seedTasks()
	{
		$data = array(
			/**
			 * Messages Actions
			 */
			array(
				'action' => 'create',
				'component' => 'messages',
				'level' => 0,
				'name' => 'Write Messages',
				'desc' => 'Write and send messages to other users.'),
			array(
				'action' => 'read',
				'component' => 'messages',
				'level' => 0,
				'name' => 'Read Messages',
				'desc' => 'Read own messages.'),
			array(
				'action' => 'delete',
				'component' => 'messages',
				'level' => 0,
				'name' => 'Delete Messages',
				'desc' => 'Delete own messages.'),
			
			/**
			 * User Actions
			 */
			array(
				'action' => 'create',
				'component' => 'user',
				'level' => 0,
				'name' => 'Create User',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'user',
				'level' => 0,
				'name' => 'View All Users',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'user',
				'level' => 1,
				'name' => 'Edit User (Level 1)',
				'desc' => 'Update own user account.'),
			array(
				'action' => 'update',
				'component' => 'user',
				'level' => 2,
				'name' => 'Edit User (Level 2)',
				'desc' => 'Update any user account.'),
			array(
				'action' => 'delete',
				'component' => 'user',
				'level' => 0,
				'name' => 'Delete User',
				'desc' => 'User accounts associated with a character who has content associated with their account (posts, logs, announcements) cannot be deleted.'),

			/**
			 * Character Actions
			 */
			array(
				'action' => 'create',
				'component' => 'character',
				'level' => 1,
				'name' => 'Create Character (Level 1)',
				'desc' => 'Create a new non-playing character.'),
			array(
				'action' => 'create',
				'component' => 'character',
				'level' => 2,
				'name' => 'Create Character (Level 2)',
				'desc' => 'Create a new character (playing and non-playing) and accept or reject new characters.'),
			array(
				'action' => 'read',
				'component' => 'character',
				'level' => 1,
				'name' => 'View Characters',
				'desc' => 'See all characters associated with their account.'),
			array(
				'action' => 'read',
				'component' => 'character',
				'level' => 2,
				'name' => 'View Non-Playing Characters',
				'desc' => 'See all non-playing characters.'),
			array(
				'action' => 'read',
				'component' => 'character',
				'level' => 3,
				'name' => 'View All Characters',
				'desc' => 'See all characters.'),
			array(
				'action' => 'update',
				'component' => 'character',
				'level' => 1,
				'name' => 'Edit Character (Level 1)',
				'desc' => 'Update own character(s) bio.'),
			array(
				'action' => 'update',
				'component' => 'character',
				'level' => 2,
				'name' => 'Edit Character (Level 2)',
				'desc' => 'Update any non-playing character bio.'),
			array(
				'action' => 'update',
				'component' => 'character',
				'level' => 3,
				'name' => 'Edit Character (Level 3)',
				'desc' => 'Update any character bio.'),
			array(
				'action' => 'delete',
				'component' => 'character',
				'level' => 0,
				'name' => 'Delete Character',
				'desc' => 'Characters who have content (posts, logs, announcements, etc.) cannot be deleted.'),

			/**
			 * Mission Post Actions
			 */
			array(
				'action' => 'create',
				'component' => 'post',
				'level' => 0,
				'name' => 'Create Post',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'post',
				'level' => 0,
				'name' => 'View Mission Posts',
				'desc' => 'See all non-activated mission posts.'),
			array(
				'action' => 'update',
				'component' => 'post',
				'level' => 1,
				'name' => 'Edit Post (Level 1)',
				'desc' => 'Update own mission posts.'),
			array(
				'action' => 'update',
				'component' => 'post',
				'level' => 2,
				'name' => 'Edit Post (Level 2)',
				'desc' => 'Update any mission post.'),
			array(
				'action' => 'delete',
				'component' => 'post',
				'level' => 0,
				'name' => 'Delete Post',
				'desc' => ''),

			/**
			 * Personal Log Actions
			 */
			array(
				'action' => 'create',
				'component' => 'log',
				'level' => 0,
				'name' => 'Create Log',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'log',
				'level' => 0,
				'name' => 'View Personal Logs',
				'desc' => 'See all non-activated personal logs.'),
			array(
				'action' => 'update',
				'component' => 'log',
				'level' => 1,
				'name' => 'Edit Log (Level 1)',
				'desc' => 'Update own personal logs.'),
			array(
				'action' => 'update',
				'component' => 'log',
				'level' => 2,
				'name' => 'Edit Log (Level 2)',
				'desc' => 'Update any personal log.'),
			array(
				'action' => 'delete',
				'component' => 'log',
				'level' => 0,
				'name' => 'Delete Log',
				'desc' => ''),

			/**
			 * Announcement Actions
			 */
			array(
				'action' => 'create',
				'component' => 'announcement',
				'level' => 0,
				'name' => 'Create Announcement',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'announcement',
				'level' => 0,
				'name' => 'View Announcements',
				'desc' => 'See all non-activated announcements.'),
			array(
				'action' => 'update',
				'component' => 'announcement',
				'level' => 1,
				'name' => 'Edit Announcement (Level 1)',
				'desc' => 'Update own announcements.'),
			array(
				'action' => 'update',
				'component' => 'announcement',
				'level' => 2,
				'name' => 'Edit Announcement (Level 2)',
				'desc' => 'Update any announcement.'),
			array(
				'action' => 'delete',
				'component' => 'announcement',
				'level' => 0,
				'name' => 'Delete Announcement',
				'desc' => ''),

			/**
			 * Comment Actions
			 */
			array(
				'action' => 'create',
				'component' => 'comment',
				'level' => 0,
				'name' => 'Create Comment',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'comment',
				'level' => 0,
				'name' => 'View All Comments',
				'desc' => 'See all non-activated comments.'),
			array(
				'action' => 'update',
				'component' => 'comment',
				'level' => 0,
				'name' => 'Edit Comment',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'comment',
				'level' => 0,
				'name' => 'Delete Comment',
				'desc' => ''),

			/**
			 * Report Actions
			 */
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 1,
				'name' => 'View Reports (Level 1)',
				'desc' => 'See the sim stats and milestone reports.'),
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 2,
				'name' => 'View Reports (Level 2)',
				'desc' => 'See the crew activity and posting reports as well as all level 1 reports.'),
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 3,
				'name' => 'View Reports (Level 3)',
				'desc' => 'See the LOA and award nomination reports as well as all level 1 and 2 reports.'),
			array(
				'action' => 'read',
				'component' => 'report',
				'level' => 4,
				'name' => 'View Reports (Level 4)',
				'desc' => 'See all system reports.'),

			/**
			 * Ban Actions
			 */
			array(
				'action' => 'create',
				'component' => 'ban',
				'level' => 0,
				'name' => 'Create Ban',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'ban',
				'level' => 0,
				'name' => 'View All Bans',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'ban',
				'level' => 0,
				'name' => 'Edit Ban',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'ban',
				'level' => 0,
				'name' => 'Delete Ban',
				'desc' => ''),

			/**
			 * Position Actions
			 */
			array(
				'action' => 'create',
				'component' => 'position',
				'level' => 0,
				'name' => 'Create Position',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'position',
				'level' => 0,
				'name' => 'View All Positions',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'position',
				'level' => 0,
				'name' => 'Edit Position',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'position',
				'level' => 0,
				'name' => 'Delete Position',
				'desc' => ''),

			/**
			 * Rank Actions
			 */
			array(
				'action' => 'create',
				'component' => 'rank',
				'level' => 0,
				'name' => 'Create Rank',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'rank',
				'level' => 0,
				'name' => 'View All Ranks',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'rank',
				'level' => 0,
				'name' => 'Edit Rank',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'rank',
				'level' => 0,
				'name' => 'Delete Rank',
				'desc' => ''),

			/**
			 * Department Actions
			 */
			array(
				'action' => 'create',
				'component' => 'department',
				'level' => 0,
				'name' => 'Create Department',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'department',
				'level' => 0,
				'name' => 'View All Departments',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'department',
				'level' => 0,
				'name' => 'Edit Department',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'department',
				'level' => 0,
				'name' => 'Delete Department',
				'desc' => ''),

			/**
			 * Catalog Actions
			 */
			array(
				'action' => 'create',
				'component' => 'catalog',
				'level' => 0,
				'name' => 'Create Catalog',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'catalog',
				'level' => 0,
				'name' => 'View All Catalogs',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'catalog',
				'level' => 0,
				'name' => 'Edit Catalog',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'catalog',
				'level' => 0,
				'name' => 'Delete Catalog',
				'desc' => ''),

			/**
			 * Form Actions
			 */
			array(
				'action' => 'read',
				'component' => 'form',
				'level' => 0,
				'name' => 'View All Forms',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'form',
				'level' => 0,
				'name' => 'Edit Form',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'form',
				'level' => 0,
				'name' => 'Delete Form',
				'desc' => ''),

			/**
			 * Navigation Actions
			 */
			array(
				'action' => 'create',
				'component' => 'nav',
				'level' => 0,
				'name' => 'Create Navigation Item',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'nav',
				'level' => 0,
				'name' => 'View All Navigation',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'nav',
				'level' => 0,
				'name' => 'Edit Navigation',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'nav',
				'level' => 0,
				'name' => 'Delete Navigation Item',
				'desc' => ''),

			/**
			 * Role Actions
			 */
			array(
				'action' => 'create',
				'component' => 'role',
				'level' => 0,
				'name' => 'Create Role',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'role',
				'level' => 0,
				'name' => 'View All Roles',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'role',
				'level' => 0,
				'name' => 'Edit Role',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'role',
				'level' => 0,
				'name' => 'Delete Role',
				'desc' => ''),

			/**
			 * Content Actions
			 */
			array(
				'action' => 'create',
				'component' => 'content',
				'level' => 0,
				'name' => 'Create Content',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'content',
				'level' => 0,
				'name' => 'View All Content',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'content',
				'level' => 0,
				'name' => 'Edit Content',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'content',
				'level' => 0,
				'name' => 'Delete Content',
				'desc' => ''),

			/**
			 * Settings Actions
			 */
			array(
				'action' => 'create',
				'component' => 'settings',
				'level' => 0,
				'name' => 'Create Setting',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'settings',
				'level' => 0,
				'name' => 'View All Settings',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'settings',
				'level' => 0,
				'name' => 'Edit Setting',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'settings',
				'level' => 0,
				'name' => 'Delete Setting',
				'desc' => ''),

			/**
			 * Specs Actions
			 */
			array(
				'action' => 'create',
				'component' => 'specs',
				'level' => 0,
				'name' => 'Create Specification',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'specs',
				'level' => 0,
				'name' => 'View All Specifications',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'specs',
				'level' => 0,
				'name' => 'Edit Specification',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'specs',
				'level' => 0,
				'name' => 'Delete Specification',
				'desc' => ''),

			/**
			 * Tour Actions
			 */
			array(
				'action' => 'create',
				'component' => 'tour',
				'level' => 0,
				'name' => 'Create Tour',
				'desc' => ''),
			array(
				'action' => 'read',
				'component' => 'tour',
				'level' => 0,
				'name' => 'View All Tour Items',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'tour',
				'level' => 0,
				'name' => 'Edit Tour',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'tour',
				'level' => 0,
				'name' => 'Delete Tour',
				'desc' => ''),

			/**
			 * Wiki Actions
			 */
			array(
				'action' => 'create',
				'component' => 'wiki',
				'level' => 1,
				'name' => 'Create Wiki Page',
				'desc' => ''),
			array(
				'action' => 'create',
				'component' => 'wiki',
				'level' => 2,
				'name' => 'Create Wiki Categories',
				'desc' => ''),
			array(
				'action' => 'update',
				'component' => 'wiki',
				'level' => 1,
				'name' => 'Edit Wiki (Level 1)',
				'desc' => 'Update own wiki pages'),
			array(
				'action' => 'update',
				'component' => 'wiki',
				'level' => 2,
				'name' => 'Edit Wiki (Level 2)',
				'desc' => 'Update and revert all wiki pages'),
			array(
				'action' => 'update',
				'component' => 'wiki',
				'level' => 3,
				'name' => 'Edit Wiki (Level 3)',
				'desc' => 'Update wiki categories'),
			array(
				'action' => 'delete',
				'component' => 'wiki',
				'level' => 1,
				'name' => 'Delete Wiki Page',
				'desc' => ''),
			array(
				'action' => 'delete',
				'component' => 'wiki',
				'level' => 2,
				'name' => 'Delete Wiki Categories',
				'desc' => ''),

			# TODO: forum actions
		);
		
		foreach ($data as $value)
		{
			AccessTask::add($value);
		}
	}

}