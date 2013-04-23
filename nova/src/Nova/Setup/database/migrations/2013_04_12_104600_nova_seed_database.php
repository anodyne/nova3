<?php

use Illuminate\Database\Migrations\Migration;

class NovaSeedDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Eloquent::unguard();

		/**
		 * Access Role Seeds
		 */
		$this->seedRoles();
		$this->seedRoleTasks();
		$this->seedTasks();

		/**
		 * App Seeds
		 */
		$this->seedApp();

		/**
		 * Catalog Seeds
		 */
		$this->seedRankCatalog();
		$this->seedSkinCatalog();

		/**
		 * Form Seeds
		 */
		$this->seedForms();
		$this->seedFormFields();
		$this->seedFormSections();
		$this->seedFormTabs();
		$this->seedFormValues();

		/**
		 * Manifest Seeds
		 */
		$this->seedManifest();

		/**
		 * Navigation Seeds
		 */
		$this->seedNav();

		/**
		 * Settings Seeds
		 */
		$this->seedSettings();

		/**
		 * Sim Type Seeds
		 */
		$this->seedSimType();

		/**
		 * Site Content Seeds
		 */
		$this->seedSiteContent();

		/**
		 * Genre Seeders
		 */
		$this->seedDepts();
		$this->seedPositions();
		$this->seedRanks();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
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

	protected function seedApp()
	{
		$rules = array(
			array(
				'type' => 'global',
				'users' => '{"position":[2]}'),
		);

		foreach ($rules as $r)
		{
			NovaAppRule::add($r);
		}
	}

	protected function seedRankCatalog()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/assets/install/genres/{$genre}.php";

		foreach ($catalog_ranks as $c)
		{
			RankCatalog::add($c);
		}
	}

	protected function seedSkinCatalog()
	{
		$skins = array(
			array(
				'name' => 'Default',
				'location' => 'default',
				'credits' => '',
				'version' => ''
			),
		);

		foreach ($skins as $s)
		{
			SkinCatalog::add($s);
		}

		$skinSections = array(
			array(
				'section' => 'main',
				'skin' => 'default',
				'preview' => 'preview-main.jpg',
				'default' => (int) true),
			array(
				'section' => 'login',
				'skin' => 'default',
				'preview' => 'preview-login.jpg',
				'default' => (int) true),
			array(
				'section' => 'admin',
				'skin' => 'default',
				'preview' => 'preview-admin.jpg',
				'default' => (int) true),
		);

		foreach ($skinSections as $c)
		{
			SkinSectionCatalog::add($c);
		}
	}

	protected function seedForms()
	{
		$data = array(
			array(
				'key' => 'character',
				'name' => 'Character Information'),
			array(
				'key' => 'user',
				'name' => 'User Information'),
			array(
				'key' => 'app',
				'name' => 'Application Information'),
		);

		foreach ($data as $d)
		{
			NovaForm::add($d);
		}
	}

	protected function seedFormFields()
	{
		$data = array(
			array(
				'form_key' => 'character',
				'section_id' => 1,
				'type' => 'select',
				'html_name' => 'gender',
				'html_id' => 'gender',
				'html_rows' => 0,
				'label' => 'Gender',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 1,
				'type' => 'text',
				'html_name' => 'species',
				'html_id' => 'species',
				'html_rows' => 0,
				'label' => 'Species',
				'placeholder' => 'e.g. Human',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 1,
				'type' => 'text',
				'html_name' => 'age',
				'html_id' => 'age',
				'html_rows' => 0,
				'html_class' => 'span1',
				'label' => 'Age',
				'placeholder' => 'Age',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'height',
				'html_id' => 'height',
				'html_rows' => 0,
				'label' => 'Height',
				'placeholder' => 'e.g. 6\'2"',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'weight',
				'html_id' => 'weight',
				'html_rows' => 0,
				'label' => 'Weight',
				'placeholder' => 'e.g. 215 lbs.',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'hair_color',
				'html_id' => 'hair_color',
				'html_rows' => 0,
				'label' => 'Hair Color',
				'placeholder' => 'Hair Color',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'eye_color',
				'html_id' => 'eye_color',
				'html_rows' => 0,
				'label' => 'Eye Color',
				'placeholder' => 'Eye Color',
				'order' => 4),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'textarea',
				'html_name' => 'physical_desc',
				'html_id' => 'physical_desc',
				'html_rows' => 3,
				'html_class' => 'span8',
				'label' => 'Physical Description',
				'placeholder' => 'Enter your physical description here',
				'order' => 5),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'spouse',
				'html_id' => 'spouse',
				'html_rows' => 0,
				'label' => 'Spouse',
				'placeholder' => 'Spouse',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'children',
				'html_id' => 'children',
				'html_rows' => 3,
				'label' => 'Children',
				'placeholder' => 'Enter your character\'s children here',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'father',
				'html_id' => 'father',
				'html_rows' => 0,
				'label' => 'Father',
				'placeholder' => 'Father',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'mother',
				'html_id' => 'mother',
				'html_rows' => 0,
				'label' => 'Mother',
				'placeholder' => 'Mother',
				'order' => 4),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'siblings',
				'html_id' => 'siblings',
				'html_rows' => 3,
				'label' => 'Siblings',
				'placeholder' => 'Enter your character\'s siblings here',
				'order' => 5),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'other_family',
				'html_id' => 'other_family',
				'html_rows' => 3,
				'label' => 'Other Family',
				'placeholder' => 'Enter your character\'s other family here',
				'order' => 6),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'personality',
				'html_id' => 'personality',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'General Overview',
				'placeholder' => 'Enter your character\'s general personality overview here',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'strengths',
				'html_id' => 'strengths',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Strengths &amp; Weaknesses',
				'placeholder' => 'Enter your character\'s strengths and weaknesses here',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'ambitions',
				'html_id' => 'ambitions',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Ambitions',
				'placeholder' => 'Enter your character\'s ambitions here',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'hobbies',
				'html_id' => 'hobbies',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Hobbies &amp; Interests',
				'placeholder' => 'Enter your character\'s hobbies and interests here',
				'order' => 4),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'languages',
				'html_id' => 'languages',
				'html_rows' => 2,
				'html_class' => 'span8',
				'label' => 'Languages',
				'placeholder' => 'Enter your character\'s known languages here',
				'order' => 5),
			array(
				'form_key' => 'character',
				'section_id' => 5,
				'type' => 'textarea',
				'html_name' => 'history',
				'html_id' => 'history',
				'html_rows' => 15,
				'html_class' => 'span8',
				'label' => 'History',
				'placeholder' => 'Enter your character\'s personal history here',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 5,
				'type' => 'textarea',
				'html_name' => 'service_record',
				'html_id' => 'service_record',
				'html_rows' => 15,
				'html_class' => 'span8',
				'label' => 'Service Record',
				'placeholder' => 'Enter your character\'s service record here',
				'order' => 2),
			array(
				'form_key' => 'user',
				'type' => 'text',
				'html_name' => 'location',
				'html_id' => 'location',
				'html_rows' => 0,
				'label' => 'Location',
				'placeholder' => 'Enter your location here',
				'order' => 0),
			array(
				'form_key' => 'user',
				'type' => 'textarea',
				'html_name' => 'interests',
				'html_id' => 'interests',
				'html_rows' => 5,
				'label' => 'Interests',
				'placeholder' => 'Enter your interests here',
				'order' => 1),
			array(
				'form_key' => 'user',
				'type' => 'textarea',
				'html_name' => 'bio',
				'html_id' => 'bio',
				'html_rows' => 5,
				'label' => 'Bio',
				'placeholder' => 'Enter your bio information here',
				'order' => 2),
			array(
				'form_key' => 'app',
				'type' => 'textarea',
				'html_name' => 'experience',
				'html_id' => 'experience',
				'html_rows' => 5,
				'html_class' => 'span5',
				'label' => 'Simming Experience',
				'order' => 0),
			array(
				'form_key' => 'app',
				'type' => 'select',
				'html_name' => 'hear_about',
				'html_id' => 'hear_about',
				'html_class' => 'span5',
				'label' => 'Where Did You Hear About Us?',
				'order' => 1),
		);

		foreach ($data as $d)
		{
			NovaFormField::add($d);
		}
	}

	protected function seedFormSections()
	{
		$data = array(
			array(
				'form_key' => 'character',
				'tab_id' => 1,
				'name' => 'Character Information',
				'order' => 0),
			array(
				'form_key' => 'character',
				'tab_id' => 1,
				'name' => 'Physical Appearance',
				'order' => 1),
			array(
				'form_key' => 'character',
				'tab_id' => 2,
				'name' => 'Family',
				'order' => 2),
			array(
				'form_key' => 'character',
				'tab_id' => 3,
				'name' => 'Personality &amp; Traits',
				'order' => 0),
			array(
				'form_key' => 'character',
				'tab_id' => 4,
				'name' => '',
				'order' => 0),
		);

		foreach ($data as $d)
		{
			NovaFormSection::add($d);
		}
	}

	protected function seedFormTabs()
	{
		$data = array(
			array(
				'form_key' => 'character',
				'name' => 'Basic Info',
				'link_id' => 'one',
				'order' => 1),
			array(
				'form_key' => 'character',
				'name' => 'Personal Info',
				'link_id' => 'two',
				'order' => 2),
			array(
				'form_key' => 'character',
				'name' => 'Personality',
				'link_id' => 'three',
				'order' => 3),
			array(
				'form_key' => 'character',
				'name' => 'History',
				'link_id' => 'four',
				'order' => 4),
		);

		foreach ($data as $d)
		{
			NovaFormTab::add($d);
		}
	}

	protected function seedFormValues()
	{
		$data = array(
			array(
				'field_id' => 1,
				'value' => 'Male',
				'content' => 'Male',
				'order' => 1),
			array(
				'field_id' => 1,
				'value' => 'Female',
				'content' => 'Female',
				'order' => 2),
			array(
				'field_id' => 1,
				'value' => 'Hermaphrodite',
				'content' => 'Hermaphrodite',
				'order' => 3),
			array(
				'field_id' => 1,
				'value' => 'Neuter',
				'content' => 'Neuter',
				'order' => 4),
			array(
				'field_id' => 26,
				'value' => 'Friend',
				'content' => 'A Friend',
				'order' => 1),
			array(
				'field_id' => 26,
				'value' => 'Member',
				'content' => 'A Member of the Game',
				'order' => 2),
			array(
				'field_id' => 26,
				'value' => 'Organization',
				'content' => 'An Organization',
				'order' => 3),
			array(
				'field_id' => 26,
				'value' => 'Advertisement',
				'content' => 'An Advertisement',
				'order' => 4),
			array(
				'field_id' => 26,
				'value' => 'Search',
				'content' => 'An Internet Search',
				'order' => 5),
		);

		foreach ($data as $d)
		{
			NovaFormValue::add($d);
		}
	}

	protected function seedManifest()
	{
		// Data to seed the database with
		$data = array(
			array(
				'name' => 'Primary Manifest',
				'order' => 0,
				'desc' => "",
				'header_content' => "You can edit the header content of this manifest from Manifest Management...",
				'default' => (int) true),
		);

		// Loop through and add the data
		foreach ($data as $d)
		{
			Manifest::add($d);
		}
	}

	protected function seedNav()
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
				'url' => 'admin/main/index',
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
				'name' => 'Access Roles',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/role/index',
				'type' => 'adminsub',
				'category' => 'manage',
				'access' => 'role.read.0'),
			/*array(
				'name' => 'Forms',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/form/index',
				'type' => 'adminsub',
				'category' => 'manage',
				'access' => 'form.read.0'),
			array(
				'name' => 'Ranks',
				'group' => 2,
				'order' => 0,
				'url' => 'admin/rank/index',
				'type' => 'adminsub',
				'category' => 'manage',
				'access' => 'rank.read.0'),*/

			/*array(
				'name' => 'All Characters',
				'group' => 0,
				'order' => 0,
				'url' => 'admin/character/index',
				'type' => 'adminsub',
				'category' => 'users',
				'access' => 'character.read.0'),*/
			array(
				'name' => 'All Users',
				'group' => 1,
				'order' => 0,
				'url' => 'admin/user/index',
				'type' => 'adminsub',
				'category' => 'users',
				'access' => 'user.read.0'),
			/*array(
				'name' => 'Application Review',
				'group' => 2,
				'order' => 0,
				'url' => 'admin/application/index',
				'type' => 'adminsub',
				'category' => 'users',
				'access' => ''),*/
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

	protected function seedSettings()
	{
		$data = array(
			array(
				'key' => 'sim_name',
				'value' => '',
				'user_created' => (int) false),
			array(
				'key' => 'sim_year',
				'value' => '',
				'user_created' => (int) false),
			array(
				'key' => 'sim_type',
				'value' => 2,
				'user_created' => (int) false),
			array(
				'key' => 'maintenance',
				'value' => 'off',
				'help' => "Maintenance mode allows only admins to log in to the system while updates are being applied or other work is being done",
				'user_created' => (int) false),
			array(
				'key' => 'skin_main',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'skin_admin',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'skin_login',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'rank',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'email_status',
				'value' => Status::ACTIVE,
				'user_created' => (int) false),
			array(
				'key' => 'email_subject',
				'value' => '',
				'help' => "You can set the email subject prefix for every email that comes from the system. The default is your sim name inside brackets.",
				'user_created' => (int) false),
			array(
				'key' => 'email_name',
				'value' => 'Nova',
				'user_created' => (int) false),
			array(
				'key' => 'email_address',
				'value' => 'me@example.com',
				'help' => "To avoid some email services marking emails from Nova as spam, use this email address to set a specific address. This defaults to an address that should prevent this issue.",
				'user_created' => (int) false),
			array(
				'key' => 'email_protocol',
				'value' => 'mail',
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_server',
				'value' => 'smtp.example.com',
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_port',
				'value' => 25,
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_encryption',
				'value' => '',
				'help' => "Nova supports sending SMTP emails over SSL or TLS. If you aren't using encryption, leave this blank.",
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_username',
				'value' => 'username',
				'user_created' => (int) false),
			array(
				'key' => 'email_smtp_password',
				'value' => 'password',
				'user_created' => (int) false),
			array(
				'key' => 'email_sendmail_path',
				'value' => '/usr/sbin/sendmail -bs',
				'user_created' => (int) false),
			array(
				'key' => 'timezone',
				'value' => 'UTC',
				'user_created' => (int) false),
			array(
				'key' => 'date_format',
				'value' => '%d %B %Y',
				'user_created' => (int) false),
			array(
				'key' => 'updates',
				'value' => '4',
				'user_created' => (int) false),
			array(
				'key' => 'post_count_format',
				'value' => 'multiple',
				'help' => "Posts can be counted in two ways: one post no matter how many authors (single) or a post for each author (multiple)",
				'user_created' => (int) false),
			array(
				'key' => 'use_mission_notes',
				'value' => 'y',
				'user_created' => (int) false),
			array(
				'key' => 'online_timespan',
				'value' => '5',
				'help' => "This is used for the Who's Online feature and should be set in minutes. The higher the number, the less accurate the data, but the lower impact it'll have on the server.",
				'user_created' => (int) false),
			array(
				'key' => 'posting_requirement',
				'value' => 14,
				'help' => "The timespan (in days) that a player must post within. Set this to 0 to remove the requirement.",
				'user_created' => (int) false),
			array(
				'key' => 'login_attempts',
				'value' => 5,
				'help' => "The number of times a user can attempt to log in before being locked out. This feature exists to help protect sites against brute-force attacks.",
				'user_created' => (int) false),
			array(
				'key' => 'login_lockout_time',
				'value' => 15,
				'help' => "When a user is locked out because of too many log in attempts, this is the number of minutes they need to wait before logging in again. This goes hand-in-hand with the lockout system to protect against brute-force atatcks.",
				'user_created' => (int) false),
			array(
				'key' => 'meta_description',
				'value' => "Anodyne Productions' premier online RPG management software",
				'user_created' => (int) false),
			array(
				'key' => 'meta_keywords',
				'value' => "nova, rpg management, anodyne, rpg, sms",
				'user_created' => (int) false),
			array(
				'key' => 'meta_author',
				'value' => "Anodyne Productions",
				'user_created' => (int) false),
		);

		// Loop through and insert the data
		foreach ($data as $d)
		{
			Settings::add($d);
		}
	}

	protected function seedSimType()
	{
		// Data to seed the database with
		$data = array(
			array('name' => 'all'),
			array('name' => 'ship'),
			array('name' => 'base'),
			array('name' => 'colony'),
			array('name' => 'unit'),
			array('name' => 'realm'),
			array('name' => 'planet'),
			array('name' => 'organization'),
		);

		// Loop through the data and add it
		foreach ($data as $d)
		{
			SimType::add($d);
		}
	}

	protected function seedSiteContent()
	{
		$data = array(
			/**
			 * Headers
			 */
			array(
				'key' => 'login_index_header',
				'label' => 'Login Header',
				'content' => "Log In",
				'type' => 'header',
				'section' => 'login',
				'page' => 'index'),
			array(
				'key' => 'login_reset_header',
				'label' => 'Reset Password Header',
				'content' => "Reset Password",
				'type' => 'header',
				'section' => 'login',
				'page' => 'reset'),
			array(
				'key' => 'login_reset_confirm_header',
				'label' => 'Confirm Reset Password Header',
				'content' => "Confirm Password Reset",
				'type' => 'header',
				'section' => 'login',
				'page' => 'reset_confirm'),
			array(
				'key' => 'login_logout_header',
				'label' => 'Logout Header',
				'content' => "Logout",
				'type' => 'header',
				'section' => 'login',
				'page' => 'logout'),
			array(
				'key' => 'main_index_header',
				'label' => 'Main Page Header',
				'content' => "Welcome to Nova!",
				'type' => 'header',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_header',
				'label' => 'Site Credits Header',
				'content' => 'Site Credits',
				'type' => 'header',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_header',
				'label' => 'Join Header',
				'content' => 'Join',
				'type' => 'header',
				'section' => 'main',
				'page' => 'join'),
			array(
				'key' => 'sim_index_header',
				'label' => 'Sim Header',
				'content' => "The Sim",
				'type' => 'header',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_header',
				'label' => 'ACP Header',
				'content' => "Control Panel",
				'type' => 'header',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_form_index_header',
				'label' => 'Form Management Header',
				'content' => "Forms",
				'type' => 'header',
				'section' => 'form',
				'page' => 'index'),
			array(
				'key' => 'admin_form_fields_header',
				'label' => 'Form Field Management Header',
				'content' => "Manage Form Fields",
				'type' => 'header',
				'section' => 'form',
				'page' => 'fields'),
			array(
				'key' => 'admin_form_sections_header',
				'label' => 'Form Section Management Header',
				'content' => "Manage Form Sections",
				'type' => 'header',
				'section' => 'form',
				'page' => 'sections'),
			array(
				'key' => 'admin_form_tabs_header',
				'label' => 'Form Tab Management Header',
				'content' => "Manage Form Tabs",
				'type' => 'header',
				'section' => 'form',
				'page' => 'tabs'),
			array(
				'key' => 'admin_ranks_index_header',
				'label' => 'Ranks Index Header',
				'content' => "Ranks",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'index'),
			array(
				'key' => 'admin_ranks_groups_header',
				'label' => 'Rank Groups Management Header',
				'content' => "Rank Groups",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'groups'),
			array(
				'key' => 'admin_ranks_info_header',
				'label' => 'Rank Info Management Header',
				'content' => "Rank Info",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'info'),
			array(
				'key' => 'admin_ranks_manage_header',
				'label' => 'Rank Management Header',
				'content' => "Ranks",
				'type' => 'header',
				'section' => 'rank',
				'page' => 'manage'),
			array(
				'key' => 'admin_arc_index_header',
				'label' => 'ARC Index Header',
				'content' => "Application Review Center",
				'type' => 'header',
				'section' => 'application',
				'page' => 'index'),
			array(
				'key' => 'admin_arc_rules_header',
				'label' => 'ARC Rules Header',
				'content' => "Application Review Rules",
				'type' => 'header',
				'section' => 'application',
				'page' => 'rules'),
			array(
				'key' => 'admin_arc_history_header',
				'label' => 'ARC History Header',
				'content' => "Application History",
				'type' => 'header',
				'section' => 'application',
				'page' => 'history'),
			array(
				'key' => 'admin_arc_review_header',
				'label' => 'ARC Review Header',
				'content' => "Application Review",
				'type' => 'header',
				'section' => 'application',
				'page' => 'review'),
			array(
				'key' => 'admin_user_management_header',
				'label' => 'User Management Header',
				'content' => "Users",
				'type' => 'header',
				'section' => 'user',
				'page' => 'index'),
			array(
				'key' => 'admin_role_index_header',
				'label' => 'Access Roles Header',
				'content' => "Manage Access Roles",
				'type' => 'header',
				'section' => 'role',
				'page' => 'index'),
			array(
				'key' => 'admin_role_tasks_header',
				'label' => 'Access Role Tasks Header',
				'content' => "Manage Access Role Tasks",
				'type' => 'header',
				'section' => 'role',
				'page' => 'tasks'),

			/**
			 * Page Titles
			 */
			array(
				'key' => 'login_index_title',
				'label' => 'Login Page Title',
				'content' => "Log In",
				'type' => 'title',
				'section' => 'login',
				'page' => 'index'),
			array(
				'key' => 'login_reset_title',
				'label' => 'Reset Password Page Title',
				'content' => "Reset Password",
				'type' => 'title',
				'section' => 'login',
				'page' => 'reset'),
			array(
				'key' => 'login_reset_confirm_title',
				'label' => 'Confirm Reset Password Page Title',
				'content' => "Confirm Password Reset",
				'type' => 'title',
				'section' => 'login',
				'page' => 'reset_confirm'),
			array(
				'key' => 'login_logout_title',
				'label' => 'Logout Page Title',
				'content' => "Logout",
				'type' => 'title',
				'section' => 'login',
				'page' => 'logout'),
			array(
				'key' => 'main_index_title',
				'label' => 'Main Page Title',
				'content' => "Welcome to Nova!",
				'type' => 'title',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_title',
				'label' => 'Site Credits Page Title',
				'content' => 'Site Credits',
				'type' => 'title',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_title',
				'label' => 'Join Page Title',
				'content' => 'Join',
				'type' => 'title',
				'section' => 'main',
				'page' => 'join'),
			array(
				'key' => 'sim_index_title',
				'label' => 'Sim Page Title',
				'content' => "The Sim",
				'type' => 'title',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_title',
				'label' => 'ACP Page Title',
				'content' => "Control Panel",
				'type' => 'title',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_form_index_title',
				'label' => 'Form Management Page Title',
				'content' => "Forms",
				'type' => 'title',
				'section' => 'form',
				'page' => 'index'),
			array(
				'key' => 'admin_form_fields_title',
				'label' => 'Form Field Management Page Title',
				'content' => "Manage Form Fields",
				'type' => 'title',
				'section' => 'form',
				'page' => 'fields'),
			array(
				'key' => 'admin_form_sections_title',
				'label' => 'Form Section Management Page Title',
				'content' => "Manage Form Sections",
				'type' => 'title',
				'section' => 'form',
				'page' => 'sections'),
			array(
				'key' => 'admin_form_tabs_title',
				'label' => 'Form Tab Management Page Title',
				'content' => "Manage Form Tabs",
				'type' => 'title',
				'section' => 'form',
				'page' => 'tabs'),
			array(
				'key' => 'admin_ranks_index_title',
				'label' => 'Ranks Index Page Title',
				'content' => "Ranks",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'index'),
			array(
				'key' => 'admin_ranks_groups_title',
				'label' => 'Rank Groups Management Page Title',
				'content' => "Rank Groups",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'groups'),
			array(
				'key' => 'admin_ranks_info_title',
				'label' => 'Rank Info Management Page Title',
				'content' => "Rank Info",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'info'),
			array(
				'key' => 'admin_ranks_manage_title',
				'label' => 'Rank Management Page Title',
				'content' => "Ranks",
				'type' => 'title',
				'section' => 'rank',
				'page' => 'manage'),
			array(
				'key' => 'admin_arc_index_title',
				'label' => 'ARC Index Page Title',
				'content' => "Application Review Center",
				'type' => 'title',
				'section' => 'application',
				'page' => 'index'),
			array(
				'key' => 'admin_arc_rules_title',
				'label' => 'ARC Rules Page Title',
				'content' => "Application Review Rules",
				'type' => 'title',
				'section' => 'application',
				'page' => 'rules'),
			array(
				'key' => 'admin_arc_history_title',
				'label' => 'ARC History Page Title',
				'content' => "Application History",
				'type' => 'title',
				'section' => 'application',
				'page' => 'history'),
			array(
				'key' => 'admin_arc_review_title',
				'label' => 'ARC Review Page Title',
				'content' => "Application Review",
				'type' => 'title',
				'section' => 'application',
				'page' => 'review'),
			array(
				'key' => 'admin_user_management_title',
				'label' => 'User Management Page Title',
				'content' => "Users",
				'type' => 'title',
				'section' => 'user',
				'page' => 'index'),
			array(
				'key' => 'admin_role_index_title',
				'label' => 'Access Roles Title',
				'content' => "Access Roles",
				'type' => 'title',
				'section' => 'role',
				'page' => 'index'),
			array(
				'key' => 'admin_role_tasks_title',
				'label' => 'Access Role Tasks Title',
				'content' => "Access Role Tasks",
				'type' => 'title',
				'section' => 'role',
				'page' => 'tasks'),

			/**
			 * Messages
			 */
			array(
				'key' => 'login_reset_message',
				'label' => 'Reset Password Message',
				'content' => "To reset your password, simply enter your email address. You'll receive an email shortly with a link to confirm your password reset. If you log in to the site before confirming your password reset, the reset will be cancelled.",
				'type' => 'message',
				'section' => 'login',
				'page' => 'reset',
				'protected' => (int) true),
			array(
				'key' => 'login_reset_confirm_message',
				'label' => 'Confirm Reset Password Message',
				'content' => "The second step of the password reset process is confirmation. In order to complete your password reset, enter a new password and click the button below and your password will be changed. If you did not request a password reset, you can simply log in to the site to cancel the reset request.",
				'type' => 'message',
				'section' => 'login',
				'page' => 'reset_confirm',
				'protected' => (int) true),
			array(
				'key' => 'main_index_message',
				'label' => 'Main Page Message',
				'content' => "Define your welcome message and welcome page header through the Site Content page.",
				'type' => 'message',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_message',
				'label' => 'Credits',
				'content' => "Define your site credits through the Site Messages page.",
				'type' => 'message',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_message',
				'label' => 'Join Message',
				'content' => "Define your join message through the Site Messages page.",
				'type' => 'message',
				'section' => '',
				'page' => ''),
			array(
				'key' => 'main_join_coppa_message',
				'label' => 'COPPA Message',
				'content' => "Members are expected to follow the rules and regulations of both the game and game's organization at all times, both in character and out of character. By continuing, you affirm you will play in a proper and adequate manner. In compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), players under the age of 13 will not be accepted and any player found to be under the age of 13 will be removed immediately and without question.",
				'type' => 'message',
				'section' => '',
				'page' => ''),
			array(
				'key' => 'sim_index_message',
				'label' => 'Sim Message',
				'content' => "Define your sim message through the Site Content page.",
				'type' => 'message',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_message',
				'label' => 'ACP Message',
				'content' => "Define your admin control panel through the Site Content page.",
				'type' => 'message',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_ranks_groups_message',
				'label' => 'Manage Rank Groups Message',
				'content' => "Rank groups are a simple way to organize ranks into logical groupings. Every rank in the system belongs to a rank group, allowing admins to easily add new groups of ranks. Nova comes with several rank groups already, but you can easily create new groups and add ranks to them from rank management.",
				'type' => 'message',
				'section' => 'rank',
				'page' => 'groups'),
			array(
				'key' => 'admin_ranks_info_message',
				'label' => 'Manage Rank Info Message',
				'content' => "Rank info contains all of the basic information about ranks that's repeated across multiple ranks, like name, short name, and order. Every rank in the system references one of the rank info records below, meaning that several ranks can be updated simultaneously by changing one of the info records. You can easily create new info records and use them with ranks or edit existing items.",
				'type' => 'message',
				'section' => 'rank',
				'page' => 'info'),
			array(
				'key' => 'admin_ranks_manage_message',
				'label' => 'Manage Ranks Message',
				'content' => "Ranks are made up of several different componets to keep things as flexible as possible. The ranks records below are composed of a rank info, a rank group, a base image, and a pip image. From here, you can change any and all of those pieces to customize your ranks to your liking.",
				'type' => 'message',
				'section' => 'rank',
				'page' => 'manage'),
			array(
				'key' => 'admin_arc_index_message',
				'label' => 'ARC Index Message',
				'content' => "",
				'type' => 'message',
				'section' => 'application',
				'page' => 'index'),
			array(
				'key' => 'admin_arc_rules_message',
				'label' => 'ARC Rules Message',
				'content' => "Application review rules are a way to automatically add specific users or users who hold specific positions to a review when an application is received. You can create as many rules as you want that will be evaluated and run on every new application. Rules whose conditions cannot be met will be ignored.",
				'type' => 'message',
				'section' => 'application',
				'page' => 'rules'),
			array(
				'key' => 'admin_role_index_message',
				'label' => 'Access Roles Message',
				'content' => "Access roles control exactly what a user can and can't do in Nova. Some sensible defaults are included for managing your users, but you're free to create and edit these roles to fit your own game. Be careful when editing or deleting existing roles as doing so could prevent you or others from accessing areas of Nova.",
				'type' => 'message',
				'section' => 'role',
				'page' => 'index'),
			array(
				'key' => 'admin_role_tasks_message',
				'label' => 'Access Roles Tasks Message',
				'content' => "Access roles are made up of tasks. Each task defines something a user can do such as creating, updating, deleting or even seeing entries. When combined with a component, this system allows for granular control over what a user can and can't do in Nova. You can edit any tasks in system or even create your own for your own pages or MODs. Be careful when editing or deleting existing items as doing so could prevent you or others from accessing areas of Nova.",
				'type' => 'message',
				'section' => 'role',
				'page' => 'tasks'),

			/**
			 * Other Messages
			 */
			array(
				'key' => 'credits_perm',
				'label' => 'Permanent Credits',
				'content' => "The Nova 3 experience can be summed up as \"smarter and better\". From the top down, Nova is faster, simpler, more flexible, and smarter than before. This is accomplished in no small part by the simple, flexible, and elegant PHP 5.3 foundation of <a href='http://fuelphp.com/' target='_blank'>FuelPHP</a>. The icons found throughout Nova are the tireless work of <a href='http://p.yusukekamiyamane.com/' target='_blank'>Yusuke Kamiyamane</a> (Fugue), <a href='http://pictos.cc' target='_blank'>Drew Wilson</a> (Pictos), and <a href='http://glyphicons.com/' target='_blank'>Jan Kovařík</a> (Glyphicons).",
				'protected' => (int) true,
				'type' => 'other'),
			array(
				'key' => 'footer',
				'label' => 'Additional Footer Information',
				'content' => "New to Nova 3 is the ability to add additional information to the footer, like banner exchanges, without having to edit any files. Just plug your code/message into the 'Additional Footer Information' site content item!",
				'type' => 'other'),
			array(
				'key' => 'join_disclaimer',
				'label' => 'Join Disclaimer',
				'content' => "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
				'type' => 'other'),
			array(
				'key' => 'join_sample_post',
				'label' => 'Join Sample Post',
				'content' => "Define your join sample post through the Site Content page. If you don't want to use a sample post, simply leave this blank.",
				'type' => 'other'),
			array(
				'key' => 'accept_message',
				'label' => 'User Acceptance Email',
				'content' => "Define your user acceptance message through the Site Content page.",
				'type' => 'other'),
			array(
				'key' => 'reject_message',
				'label' => 'User Rejection Message',
				'content' => "Define your user rejection message through the Site Content page.",
				'type' => 'other'),
			array(
				'key' => 'join_character_help',
				'label' => 'Join Character Help',
				'content' => "__Tips for a good character application:__

* Be unique. No one likes interacting with a character that can do everything perfectly. Look for ways to make your character fresh and exciting and to give them shortcomings and weaknesses.
* A character isn't his/her position, but a person with a job. Before they work here, they started somewhere. In this sense, their past has defined their arrival to this place and defined who they are. What brought the character here? There should be a logical reason the character is in the here-and-now of the game situation.
* A character fits into the world in a specific way. They were born somewhere and are a product of their time (war, poverty, disease, prosperity, etc.). Use those factors to craft a narrative about the character.
* Many people choose to use exaggerated aspects of their own personality (as well as a complimentary weakness). Doing so will make it easier to write the character because you know how you would react in given situations.",
		'type' => 'other'),
		);

		// Loop through the insert the data
		foreach ($data as $d)
		{
			SiteContent::add($d);
		}
	}

	protected function seedDepts()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/assets/install/genres/{$genre}.php";

		// Loop through the departments and seed the data
		foreach ($depts as $d)
		{
			Dept::add($d);
		}
	}

	protected function seedPositions()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/assets/install/genres/{$genre}.php";

		foreach ($positions as $p)
		{
			Position::add($p);
		}
	}

	protected function seedRanks()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/assets/install/genres/{$genre}.php";

		foreach ($info as $i)
		{
			RankInfo::add($i);
		}

		foreach ($groups as $g)
		{
			RankGroup::add($g);
		}

		foreach ($ranks as $r)
		{
			Rank::add($r);
		}
	}

}