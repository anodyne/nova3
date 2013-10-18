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
		$this->seedFormTabs();
		$this->seedFormSections();
		$this->seedFormFields();
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
			AccessRoleModel::create($value);
		}
	}

	protected function seedRoleTasks()
	{
		$data = [
			2 => [1, 2, 3, 5],
			3 => [8, 10, 14, 15, 17, 20, 21, 23, 32, 35, 57],
			4 => [11, 16, 22, 26, 29, 36],
			5 => [18, 24, 28, 30, 12, 13, 6, 33, 34, 37],
			6 => [4, 7, 9, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72],
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
			AccessTaskModel::create($value);
		}
	}

	protected function seedApp()
	{
		$rules = [
			['type' => 'global', 'users' => '{"position":[2]}'],
		];

		foreach ($rules as $r)
		{
			ApplicationRuleModel::create($r);
		}
	}

	protected function seedRankCatalog()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/database/genres/{$genre}.php";

		foreach ($catalog_ranks as $c)
		{
			RankCatalogModel::create($c);
		}
	}

	protected function seedSkinCatalog()
	{
		$skins = [
			['name' => 'Default', 'location' => 'default'],
		];

		foreach ($skins as $s)
		{
			SkinCatalogModel::create($s);
		}
	}

	protected function seedForms()
	{
		$data = [
			[
				'key'			=> 'character',
				'name'			=> 'Character Information',
				'protected'		=> (int) true,
				'data_model'	=> 'CharacterModel',
			],
			[
				'key'			=> 'user',
				'name'			=> 'User Information',
				'protected'		=> (int) true,
				'data_model'	=> 'UserModel',
			],
			[
				'key'			=> 'app',
				'name'			=> 'Application Information',
				'protected'		=> (int) true,
				'data_model'	=> 'ApplicationModel',
			],
		];

		foreach ($data as $d)
		{
			FormModel::create($d);
		}
	}

	protected function seedFormFields()
	{
		$data = [
			[
				'form_id' => 1,
				'section_id' => 1,
				'type' => 'select',
				'html_id' => 'gender',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Gender',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 1,
				'type' => 'text',
				'html_id' => 'species',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Species',
				'placeholder' => 'e.g. Human',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 1,
				'type' => 'text',
				'html_id' => 'age',
				'html_rows' => 0,
				'html_container_class' => 'col-md-2 col-lg-2',
				'label' => 'Age',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_id' => 'height',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Height',
				'placeholder' => 'e.g. 6\'2"',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_id' => 'weight',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Weight',
				'placeholder' => 'e.g. 215 lbs.',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_id' => 'hair_color',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Hair Color',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'text',
				'html_id' => 'eye_color',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Eye Color',
				'order' => 4
			],
			[
				'form_id' => 1,
				'section_id' => 2,
				'type' => 'textarea',
				'html_id' => 'physical_desc',
				'html_rows' => 3,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Physical Description',
				'order' => 5
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'text',
				'html_id' => 'spouse',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Spouse',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'textarea',
				'html_id' => 'children',
				'html_rows' => 3,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Children',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'text',
				'html_id' => 'father',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Father',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'text',
				'html_id' => 'mother',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Mother',
				'order' => 4
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'textarea',
				'html_id' => 'siblings',
				'html_rows' => 3,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Siblings',
				'order' => 5
			],
			[
				'form_id' => 1,
				'section_id' => 3,
				'type' => 'textarea',
				'html_id' => 'other_family',
				'html_rows' => 3,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Other Family',
				'order' => 6
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_id' => 'personality',
				'html_rows' => 5,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'General Overview',
				'order' => 1
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_id' => 'strengths',
				'html_rows' => 5,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Strengths &amp; Weaknesses',
				'order' => 2
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_id' => 'ambitions',
				'html_rows' => 5,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Ambitions',
				'order' => 3
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_id' => 'hobbies',
				'html_rows' => 5,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Hobbies &amp; Interests',
				'order' => 4
			],
			[
				'form_id' => 1,
				'section_id' => 4,
				'type' => 'textarea',
				'html_id' => 'languages',
				'html_rows' => 2,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Languages',
				'order' => 5
			],
			[
				'form_id' => 1,
				'tab_id' => 4,
				'type' => 'textarea',
				'html_id' => 'history',
				'html_rows' => 15,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'History',
				'order' => 1
			],
			[
				'form_id' => 1,
				'tab_id' => 4,
				'type' => 'textarea',
				'html_id' => 'service_record',
				'html_rows' => 15,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Service Record',
				'order' => 2
			],
			[
				'form_id' => 2,
				'type' => 'text',
				'html_id' => 'location',
				'html_rows' => 0,
				'html_container_class' => 'col-md-4 col-lg-4',
				'label' => 'Location',
				'placeholder' => 'e.g. United States',
				'order' => 0
			],
			[
				'form_id' => 2,
				'type' => 'textarea',
				'html_id' => 'interests',
				'html_rows' => 5,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Interests',
				'order' => 1
			],
			[
				'form_id' => 2,
				'type' => 'textarea',
				'html_id' => 'bio',
				'html_rows' => 5,
				'html_container_class' => 'col-md-8 col-lg-8',
				'label' => 'Bio',
				'order' => 2
			],
			[
				'form_id' => 3,
				'type' => 'textarea',
				'html_id' => 'experience',
				'html_rows' => 5,
				'html_container_class' => 'col-md-5 col-lg-5',
				'label' => 'Simming Experience',
				'order' => 0
			],
			[
				'form_id' => 3,
				'type' => 'select',
				'html_id' => 'hear_about',
				'html_container_class' => 'col-md-5 col-lg-5',
				'label' => 'Where Did You Hear About Us?',
				'order' => 1
			],
		];

		foreach ($data as $d)
		{
			FormFieldModel::create($d);
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
		];

		foreach ($data as $d)
		{
			FormSectionModel::create($d);
		}
	}

	protected function seedFormTabs()
	{
		$data = [
			[
				'form_id' => 1,
				'name' => 'Basic Info',
				'link_id' => 'BasicInfo',
				'order' => 1
			],
			[
				'form_id' => 1,
				'name' => 'Personal Info',
				'link_id' => 'PersonalInfo',
				'order' => 2
			],
			[
				'form_id' => 1,
				'name' => 'Personality',
				'link_id' => 'Personality',
				'order' => 3
			],
			[
				'form_id' => 1,
				'name' => 'History',
				'link_id' => 'History',
				'order' => 4
			],
		];

		foreach ($data as $d)
		{
			FormTabModel::create($d);
		}
	}

	protected function seedFormValues()
	{
		$data = [
			['field_id' => 1, 'value' => 'Male', 'order' => 1],
			['field_id' => 1, 'value' => 'Female', 'order' => 2],
			['field_id' => 1, 'value' => 'Hermaphrodite', 'order' => 3],
			['field_id' => 1, 'value' => 'Neuter', 'order' => 4],
			['field_id' => 26, 'value' => 'A Friend', 'order' => 1],
			['field_id' => 26, 'value' => 'A Member of the Game', 'order' => 2],
			['field_id' => 26, 'value' => 'An Organization', 'order' => 3],
			['field_id' => 26, 'value' => 'An Advertisement', 'order' => 4],
			['field_id' => 26, 'value' => 'An Internet Search', 'order' => 5],
		];

		foreach ($data as $d)
		{
			FormValueModel::create($d);
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
			ManifestModel::create($d);
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
			SettingsModel::create($d);
		}
	}

	protected function seedSiteContent()
	{
		$data = include __DIR__.'/data/content.php';

		// Loop through the insert the data
		foreach ($data as $d)
		{
			SiteContentModel::create($d);
		}
	}

	protected function seedDepts()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/database/genres/{$genre}.php";

		// Loop through the departments and seed the data
		foreach ($depts as $d)
		{
			DeptModel::create($d);
		}
	}

	protected function seedPositions()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/database/genres/{$genre}.php";

		foreach ($positions as $p)
		{
			PositionModel::create($p);
		}
	}

	protected function seedRanks()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Pull in the genre data file
		include SRCPATH."Setup/database/genres/{$genre}.php";

		foreach ($info as $i)
		{
			RankInfoModel::create($i);
		}

		foreach ($groups as $g)
		{
			RankGroupModel::create($g);
		}

		foreach ($ranks as $r)
		{
			RankModel::create($r);
		}
	}

	protected function seedRoutes()
	{
		$data = include __DIR__.'/data/routes.php';

		// Create the routes
		foreach ($data as $d)
		{
			SystemRouteModel::create($d);
		}
	}

}