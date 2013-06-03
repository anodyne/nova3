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
		 * Route Seed
		 */
		$this->seedRoutes();

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
		$data = [
			[
				'name' => 'Inactive User',
				'desc' => "Inactive users have no privileges within the system. This role is automatically assigned to any user who has been retired.",
				'inherits' => ''
			],
			[
				'name' => 'User',
				'desc' => "Every user in the system starts with these permissions. This role is automatically assigned to any user who is not retired.",
				'inherits' => ''
			],
			[
				'name' => 'Active User',
				'desc' => "Every active user in the system has these permissions and is provided basic functionality throughout the system.",
				'inherits' => '2'
			],
			[
				'name' => 'Power User',
				'desc' => "Power users are given more access to pieces of the system to assist the game master as necessary.",
				'inherits' => '2,3'
			],
			[
				'name' => 'Administrator',
				'desc' => "Like power users, administrators are given higher permissions to the system to assist the game master as necessary.",
				'inherits' => '2,3,4'
			],
			[
				'name' => 'System Administrator',
				'desc' => "System administrators have complete control over the system. This role should only be assigned to a select few individuals who are trusted to run the game.",
				'inherits' => '2,3,4,5'
			],
		];

		foreach ($data as $value)
		{
			AccessRole::create($value);
		}
	}

	protected function seedRoleTasks()
	{
		$data = [
			2 => [1, 2, 3, 5],
			3 => [10, 14, 19, 29, 8, 16, 21, 32],
			4 => [11, 24, 26, 33],
			5 => [17, 22, 27, 12, 13, 6, 30, 31, 34],
			6 => [4, 7, 9, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68],
		];

		foreach ($data as $key => $value)
		{
			foreach ($value as $task)
			{
				DB::table('roles_tasks')->insert(['role_id' => $key, 'task_id' => $task]);
			}
		}
	}

	protected function seedTasks()
	{
		$data = include __DIR__.'/data/tasks.php';
		
		foreach ($data as $value)
		{
			AccessTask::create($value);
		}
	}

	protected function seedApp()
	{
		$rules = [
			['type' => 'global', 'users' => '{"position":[2]}'],
		];

		foreach ($rules as $r)
		{
			NovaAppRule::create($r);
		}
	}

	protected function seedRankCatalog()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."setup/assets/install/genres/{$genre}.php";

		foreach ($catalog_ranks as $c)
		{
			RankCatalog::create($c);
		}
	}

	protected function seedSkinCatalog()
	{
		$skins = [
			['name' => 'Default', 'location' => 'default'],
		];

		foreach ($skins as $s)
		{
			SkinCatalog::create($s);
		}

		$skinSections = [
			[
				'section' => 'main',
				'skin' => 'default',
				'preview' => 'preview-main.jpg',
				'default' => (int) true
			],
			[
				'section' => 'login',
				'skin' => 'default',
				'preview' => 'preview-login.jpg',
				'default' => (int) true
			],
			[
				'section' => 'admin',
				'skin' => 'default',
				'preview' => 'preview-admin.jpg',
				'default' => (int) true
			],
		];

		foreach ($skinSections as $c)
		{
			SkinSectionCatalog::create($c);
		}
	}

	protected function seedForms()
	{
		$data = [
			[
				'key'		=> 'character',
				'name'		=> 'Character Information',
				'protected'	=> (int) true,
			],
			[
				'key'		=> 'user',
				'name'		=> 'User Information',
				'protected'	=> (int) true,
			],
			[
				'key'		=> 'app',
				'name'		=> 'Application Information',
				'protected'	=> (int) true,
			],
		];

		foreach ($data as $d)
		{
			NovaForm::create($d);
		}
	}

	protected function seedFormFields()
	{
		$data = [
			[
				'form_id' => 1,
				'section_id' => 1,
				'type' => 'select',
				'html_name' => 'gender',
				'html_id' => 'gender',
				'html_rows' => 0,
				'label' => 'Gender',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 1,
				'type' => 'text',
				'html_name' => 'species',
				'html_id' => 'species',
				'html_rows' => 0,
				'label' => 'Species',
				'placeholder' => 'e.g. Human',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 1,
				'type' => 'text',
				'html_name' => 'age',
				'html_id' => 'age',
				'html_rows' => 0,
				'html_class' => 'span1',
				'label' => 'Age',
				'placeholder' => 'Age',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'height',
				'html_id' => 'height',
				'html_rows' => 0,
				'label' => 'Height',
				'placeholder' => 'e.g. 6\'2"',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'weight',
				'html_id' => 'weight',
				'html_rows' => 0,
				'label' => 'Weight',
				'placeholder' => 'e.g. 215 lbs.',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'hair_color',
				'html_id' => 'hair_color',
				'html_rows' => 0,
				'label' => 'Hair Color',
				'placeholder' => 'Hair Color',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'eye_color',
				'html_id' => 'eye_color',
				'html_rows' => 0,
				'label' => 'Eye Color',
				'placeholder' => 'Eye Color',
				'order' => 4
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'textarea',
				'html_name' => 'physical_desc',
				'html_id' => 'physical_desc',
				'html_rows' => 3,
				'html_class' => 'span8',
				'label' => 'Physical Description',
				'placeholder' => 'Enter your physical description here',
				'order' => 5
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'spouse',
				'html_id' => 'spouse',
				'html_rows' => 0,
				'label' => 'Spouse',
				'placeholder' => 'Spouse',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'children',
				'html_id' => 'children',
				'html_rows' => 3,
				'label' => 'Children',
				'placeholder' => 'Enter your character\'s children here',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'father',
				'html_id' => 'father',
				'html_rows' => 0,
				'label' => 'Father',
				'placeholder' => 'Father',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'mother',
				'html_id' => 'mother',
				'html_rows' => 0,
				'label' => 'Mother',
				'placeholder' => 'Mother',
				'order' => 4
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'siblings',
				'html_id' => 'siblings',
				'html_rows' => 3,
				'label' => 'Siblings',
				'placeholder' => 'Enter your character\'s siblings here',
				'order' => 5
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'other_family',
				'html_id' => 'other_family',
				'html_rows' => 3,
				'label' => 'Other Family',
				'placeholder' => 'Enter your character\'s other family here',
				'order' => 6
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'personality',
				'html_id' => 'personality',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'General Overview',
				'placeholder' => 'Enter your character\'s general personality overview here',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'strengths',
				'html_id' => 'strengths',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Strengths &amp; Weaknesses',
				'placeholder' => 'Enter your character\'s strengths and weaknesses here',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'ambitions',
				'html_id' => 'ambitions',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Ambitions',
				'placeholder' => 'Enter your character\'s ambitions here',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'hobbies',
				'html_id' => 'hobbies',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Hobbies &amp; Interests',
				'placeholder' => 'Enter your character\'s hobbies and interests here',
				'order' => 4
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'languages',
				'html_id' => 'languages',
				'html_rows' => 2,
				'html_class' => 'span8',
				'label' => 'Languages',
				'placeholder' => 'Enter your character\'s known languages here',
				'order' => 5
			],
			[
				'form_id' => 1,
				'section_id' => 5,
				'type' => 'textarea',
				'html_name' => 'history',
				'html_id' => 'history',
				'html_rows' => 15,
				'html_class' => 'span8',
				'label' => 'History',
				'placeholder' => 'Enter your character\'s personal history here',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 5,
				'type' => 'textarea',
				'html_name' => 'service_record',
				'html_id' => 'service_record',
				'html_rows' => 15,
				'html_class' => 'span8',
				'label' => 'Service Record',
				'placeholder' => 'Enter your character\'s service record here',
				'order' => 2
			],
			[
				'form_id' => 2,
				'type' => 'text',
				'html_name' => 'location',
				'html_id' => 'location',
				'html_rows' => 0,
				'label' => 'Location',
				'placeholder' => 'Enter your location here',
				'order' => 0
			],
			[
				'form_id' => 2,
				'type' => 'textarea',
				'html_name' => 'interests',
				'html_id' => 'interests',
				'html_rows' => 5,
				'label' => 'Interests',
				'placeholder' => 'Enter your interests here',
				'order' => 1
			],
			[
				'form_id' => 2,
				'type' => 'textarea',
				'html_name' => 'bio',
				'html_id' => 'bio',
				'html_rows' => 5,
				'label' => 'Bio',
				'placeholder' => 'Enter your bio information here',
				'order' => 2
			],
			[
				'form_id' => 3,
				'type' => 'textarea',
				'html_name' => 'experience',
				'html_id' => 'experience',
				'html_rows' => 5,
				'html_class' => 'span5',
				'label' => 'Simming Experience',
				'order' => 0
			],
			[
				'form_id' => 3,
				'type' => 'select',
				'html_name' => 'hear_about',
				'html_id' => 'hear_about',
				'html_class' => 'span5',
				'label' => 'Where Did You Hear About Us?',
				'order' => 1
			],
		];

		foreach ($data as $d)
		{
			NovaFormField::create($d);
		}
	}

	protected function seedFormSections()
	{
		$data = [
			[
				'form_id' => 1,
				'tab_id' => 1,
				'name' => 'Character Information',
				'order' => 0
			],
			[
				'form_id' => 1,
				'tab_id' => 1,
				'name' => 'Physical Appearance',
				'order' => 1
			],
			[
				'form_id' => 1,
				'tab_id' => 2,
				'name' => 'Family',
				'order' => 2
			],
			[
				'form_id' => 1,
				'tab_id' => 3,
				'name' => 'Personality &amp; Traits',
				'order' => 0
			],
			[
				'form_id' => 1,
				'tab_id' => 4,
				'name' => '',
				'order' => 0
			],
		];

		foreach ($data as $d)
		{
			NovaFormSection::create($d);
		}
	}

	protected function seedFormTabs()
	{
		$data = [
			[
				'form_id' => 1,
				'name' => 'Basic Info',
				'link_id' => 'one',
				'order' => 1
			],
			[
				'form_id' => 1,
				'name' => 'Personal Info',
				'link_id' => 'two',
				'order' => 2
			],
			[
				'form_id' => 1,
				'name' => 'Personality',
				'link_id' => 'three',
				'order' => 3
			],
			[
				'form_id' => 1,
				'name' => 'History',
				'link_id' => 'four',
				'order' => 4
			],
		];

		foreach ($data as $d)
		{
			NovaFormTab::create($d);
		}
	}

	protected function seedFormValues()
	{
		$data = [
			[
				'field_id' => 1,
				'value' => 'Male',
				'content' => 'Male',
				'order' => 1
			],
			[
				'field_id' => 1,
				'value' => 'Female',
				'content' => 'Female',
				'order' => 2
			],
			[
				'field_id' => 1,
				'value' => 'Hermaphrodite',
				'content' => 'Hermaphrodite',
				'order' => 3
			],
			[
				'field_id' => 1,
				'value' => 'Neuter',
				'content' => 'Neuter',
				'order' => 4
			],
			[
				'field_id' => 26,
				'value' => 'Friend',
				'content' => 'A Friend',
				'order' => 1
			],
			[
				'field_id' => 26,
				'value' => 'Member',
				'content' => 'A Member of the Game',
				'order' => 2
			],
			[
				'field_id' => 26,
				'value' => 'Organization',
				'content' => 'An Organization',
				'order' => 3
			],
			[
				'field_id' => 26,
				'value' => 'Advertisement',
				'content' => 'An Advertisement',
				'order' => 4
			],
			[
				'field_id' => 26,
				'value' => 'Search',
				'content' => 'An Internet Search',
				'order' => 5
			],
		];

		foreach ($data as $d)
		{
			NovaFormValue::create($d);
		}
	}

	protected function seedManifest()
	{
		// Data to seed the database with
		$data = [
			[
				'name' => 'Primary Manifest',
				'order' => 0,
				'header_content' => "You can edit the header content of this manifest from Manifest Management...",
				'default' => (int) true
			],
		];

		// Loop through and create the data
		foreach ($data as $d)
		{
			Manifest::create($d);
		}
	}

	protected function seedNav()
	{
		$data = include __DIR__.'/data/nav.php';

		foreach ($data as $d)
		{
			NavModel::create($d);
		}
	}

	protected function seedSettings()
	{
		$data = include __DIR__.'/data/settings.php';

		// Loop through the insert the data
		foreach ($data as $d)
		{
			Settings::create($d);
		}
	}

	protected function seedSimType()
	{
		// Data to seed the database with
		$data = [
			['name' => 'all'],
			['name' => 'ship'],
			['name' => 'base'],
			['name' => 'colony'],
			['name' => 'unit'],
			['name' => 'realm'],
			['name' => 'planet'],
			['name' => 'organization'],
		];

		// Loop through the data and create it
		foreach ($data as $d)
		{
			SimType::create($d);
		}
	}

	protected function seedSiteContent()
	{
		$data = include __DIR__.'/data/content.php';

		// Loop through the insert the data
		foreach ($data as $d)
		{
			SiteContent::create($d);
		}
	}

	protected function seedDepts()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."setup/assets/install/genres/{$genre}.php";

		// Loop through the departments and seed the data
		foreach ($depts as $d)
		{
			Dept::create($d);
		}
	}

	protected function seedPositions()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."setup/assets/install/genres/{$genre}.php";

		foreach ($positions as $p)
		{
			Position::create($p);
		}
	}

	protected function seedRanks()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."setup/assets/install/genres/{$genre}.php";

		foreach ($info as $i)
		{
			RankInfo::create($i);
		}

		foreach ($groups as $g)
		{
			RankGroup::create($g);
		}

		foreach ($ranks as $r)
		{
			Rank::create($r);
		}
	}

	protected function seedRoutes()
	{
		$data = include __DIR__.'/data/routes.php';

		// Create the routes
		foreach ($data as $d)
		{
			SystemRoute::create($d);
		}
	}

}