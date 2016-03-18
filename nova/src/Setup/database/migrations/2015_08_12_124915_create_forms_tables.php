<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTables extends Migration {

	protected $data;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
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
			$table->boolean('form_viewer')->default((int) false);
			$table->text('form_viewer_message')->nullable();
			$table->integer('form_viewer_display')->unsigned()->default((int) false);
			$table->boolean('email_allowed')->default((int) false);
			$table->text('email_addresses')->nullable();
			$table->string('resource_create')->default('admin.forms.formviewer.store');
			$table->string('resource_update')->default('admin.forms.formviewer.update');
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
			$table->timestamps();

			$table->foreign('form_id')->references('id')->on('forms')
				->onDelete('cascade');
		});

		Schema::create('forms_sections', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->integer('tab_id')->unsigned()->default(0);
			$table->string('name')->nullable();
			$table->integer('order');
			$table->boolean('status')->default(Status::ACTIVE);
			$table->timestamps();

			$table->foreign('form_id')->references('id')->on('forms')
				->onDelete('cascade');
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
			$table->string('field_container_class')->default('col-md-4')->nullable();
			$table->string('label_container_class')->default('col-md-2')->nullable();
			$table->text('help')->nullable();
			$table->text('attributes')->nullable();
			$table->text('restriction')->nullable();
			$table->text('validation_rules')->nullable();
			$table->text('values')->nullable();
			$table->timestamps();

			$table->foreign('form_id')->references('id')->on('forms')
				->onDelete('cascade');
		});

		Schema::create('forms_data', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('form_id')->unsigned();
			$table->integer('field_id')->unsigned();
			$table->integer('data_id')->unsigned();
			$table->text('value')->nullable();
			$table->integer('created_by')->unsigned()->default(0);
			$table->timestamps();

			$table->foreign('form_id')->references('id')->on('forms')
				->onDelete('cascade');
			$table->foreign('field_id')->references('id')->on('forms_fields')
				->onDelete('cascade');
		});

		$this->populateTables();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
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
			['character', 'tabs'],
			['character', 'sections'],
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
			'values'	=> 'FormFieldValueRepository',
		];

		foreach ($this->data[$form][$type] as $x)
		{
			app($repos[$type])->create($x);
		}
	}

}
