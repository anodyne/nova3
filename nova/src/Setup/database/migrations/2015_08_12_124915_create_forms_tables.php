<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTables extends Migration {

	protected $data;

	public function up()
	{
		Schema::create('forms', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('key', 20)->unique();
			$table->string('name');
			$table->string('orientation', 50)->default('vertical');
			$table->boolean('status')->default(Status::ACTIVE);
			$table->boolean('protected')->default((int) false);
			$table->boolean('use_form_center')->default((int) false);
			$table->text('message')->nullable();
			$table->text('email_recipients')->nullable();
			$table->string('resource_create')->default('admin.forms.formcenter.store');
			$table->string('resource_update')->default('admin.forms.formcenter.update');
			$table->boolean('allow_multiple_submissions')->default((int) false);
			$table->boolean('allow_entry_editing')->default((int) false);
			$table->boolean('allow_entry_removal')->default((int) false);
			$table->timestamps();
		});

		Schema::create('forms_tabs', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->integer('parent_id')->unsigned()->default(0);
			$table->string('name');
			$table->string('link_id')->nullable();
			$table->integer('order');
			$table->boolean('status')->default(Status::ACTIVE);
			$table->text('message')->nullable();
			$table->timestamps();
		});

		Schema::create('forms_sections', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->integer('tab_id')->unsigned()->default(0);
			$table->string('name')->nullable();
			$table->integer('order');
			$table->boolean('status')->default(Status::ACTIVE);
			$table->text('message')->nullable();
			$table->timestamps();
		});

		Schema::create('forms_fields', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->integer('tab_id')->unsigned()->default(0);
			$table->integer('section_id')->unsigned()->default(0);
			$table->string('type', 50)->default('text');
			$table->integer('order')->default(99);
			$table->boolean('status')->default(Status::ACTIVE);
			$table->string('label')->nullable();
			$table->string('field_container_class')->default('col-md-4');
			$table->string('label_container_class')->default('col-md-2');
			$table->text('help')->nullable();
			$table->text('attributes')->nullable();
			$table->text('restrictions')->nullable();
			$table->text('validation_rules')->nullable();
			$table->text('values')->nullable();
			$table->timestamps();
		});

		Schema::create('forms_data', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('form_id')->unsigned();
			$table->integer('field_id')->unsigned();
			$table->bigInteger('entry_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->text('value')->nullable();
			$table->timestamps();
		});

		Schema::create('forms_entries', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('form_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->timestamps();
		});

		$this->populateTables();
	}

	public function down()
	{
		Schema::dropIfExists('forms_entries');
		Schema::dropIfExists('forms_data');
		Schema::dropIfExists('forms_fields');
		Schema::dropIfExists('forms_sections');
		Schema::dropIfExists('forms_tabs');
		Schema::dropIfExists('forms');
	}

	protected function populateTables()
	{
		Model::unguard();

		$this->data = require_once app('path.database').'/data/forms.php';

		foreach ($this->data['forms'] as $form)
		{
			app('FormRepository')->create($form);
		}

		$run = [
			['application', 'fields'],
			['character', 'tabs'],
			['character', 'sections'],
			['character', 'fields'],
			['user', 'fields'],
		];

		foreach ($run as $r)
		{
			$this->run($r[0], $r[1]);
		}
	}

	protected function run($form, $type)
	{
		$repos = [
			'tabs'		=> 'FormTabRepository',
			'sections'	=> 'FormSectionRepository',
			'fields'	=> 'FormFieldRepository',
		];

		foreach ($this->data[$form][$type] as $x)
		{
			app($repos[$type])->create($x);
		}
	}

}
