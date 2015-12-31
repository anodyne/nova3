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
			$table->boolean('protected')->default(0);
			$table->boolean('form_viewer')->default(0);
			$table->text('form_viewer_message')->nullable();
			$table->integer('form_viewer_display')->unsigned()->default(0);
			$table->boolean('email_allowed')->default(0);
			$table->text('email_addresses')->nullable();
			$table->string('data_model')->nullable();
			$table->timestamps();
		});

		Schema::create('forms_tabs', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->integer('parent_id')->unsigned()->nullable();
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
			$table->integer('tab_id')->unsigned()->nullable();
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
			$table->string('label');
			$table->integer('order')->nullable();
			$table->boolean('status')->default(Status::ACTIVE);
			$table->text('restriction')->nullable();
			$table->text('help')->nullable();
			$table->string('selected', 50)->nullable();
			$table->string('value')->nullable();
			$table->string('html_id')->nullable();
			$table->string('html_class')->nullable();
			$table->integer('html_rows')->default(5);
			$table->string('html_container_class')->default('col-lg-4')->nullable();
			$table->text('placeholder')->nullable();
			$table->text('validation_rules')->nullable();
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

		Schema::create('forms_fields_values', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('field_id')->unsigned();
			$table->string('value');
			$table->integer('order');
			$table->timestamps();

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
		Schema::dropIfExists('forms_fields_values');
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
