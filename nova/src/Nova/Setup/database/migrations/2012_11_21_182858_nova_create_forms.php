<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateForms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms', function($t)
		{
			$t->increments('id');
			$t->string('key', 20);
			$t->string('name');
			$t->string('orientation', 50)->default('vertical');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('form_data', function($t)
		{
			$t->increments('id')->unsigned();
			$t->string('form_key', 20);
			$t->integer('field_id')->unsigned();
			$t->integer('data_id');
			$t->text('value')->nullable();
			$t->timestamps();
		});

		Schema::create('form_fields', function($t)
		{
			$t->increments('id')->unsigned();
			$t->string('form_key', 20);
			$t->integer('section_id')->nullable();
			$t->string('type', 50)->default('text');
			$t->string('label');
			$t->integer('order')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->integer('restriction')->nullable();
			$t->text('help')->nullable();
			$t->string('selected', 50)->nullable();
			$t->string('value')->nullable();
			$t->string('html_name')->nullable();
			$t->string('html_id')->nullable();
			$t->string('html_class')->nullable();
			$t->integer('html_rows')->default(5);
			$t->text('placeholder')->nullable();
			$t->timestamps();
		});

		Schema::create('form_sections', function($t)
		{
			$t->increments('id');
			$t->string('form_key', 20);
			$t->integer('tab_id')->nullable();
			$t->string('name')->nullable();
			$t->integer('order');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('form_tabs', function($t)
		{
			$t->increments('id');
			$t->string('form_key', 20);
			$t->string('name');
			$t->string('link_id', 20)->nullable();
			$t->integer('order')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('form_values', function($t)
		{
			$t->increments('id');
			$t->integer('field_id')->unsigned();
			$t->string('value');
			$t->text('content');
			$t->integer('order');
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
		Schema::drop('forms');
		Schema::drop('form_data');
		Schema::drop('form_fields');
		Schema::drop('form_sections');
		Schema::drop('form_tabs');
		Schema::drop('form_values');
	}

	protected function seed()
	{
		$this->seedForms();
		$this->seedFormFields();
		$this->seedFormSections();
		$this->seedFormTabs();
		$this->seedFormValues();
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

}