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
			$t->boolean('protected')->default(0);
			$t->boolean('form_viewer')->default(0);
			$t->text('form_viewer_message')->nullable();
			$t->integer('form_viewer_display')->unsigned()->default(0);
			$t->boolean('email_allowed')->default(0);
			$t->text('email_addresses')->nullable();
			$t->string('data_model')->nullable();
			$t->timestamps();
		});

		Schema::create('form_data', function($t)
		{
			$t->bigIncrements('id');
			$t->integer('form_id')->unsigned();
			$t->integer('field_id')->unsigned();
			$t->integer('data_id')->unsigned();
			$t->text('value')->nullable();
			$t->integer('created_by')->unsigned()->default(0);
			$t->timestamps();
		});

		Schema::create('form_fields', function($t)
		{
			$t->increments('id');
			$t->integer('form_id')->unsigned();
			$t->integer('tab_id')->unsigned()->default(0);
			$t->integer('section_id')->unsigned()->default(0);
			$t->string('type', 50)->default('text');
			$t->string('label');
			$t->integer('order')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->text('restriction')->nullable();
			$t->text('help')->nullable();
			$t->string('selected', 50)->nullable();
			$t->string('value')->nullable();
			$t->string('html_id')->nullable();
			$t->string('html_class')->nullable();
			$t->integer('html_rows')->default(5);
			$t->string('html_container_class')->default('col-lg-4')->nullable();
			$t->text('placeholder')->nullable();
			$t->text('validation_rules')->nullable();
			$t->timestamps();
		});

		Schema::create('form_sections', function($t)
		{
			$t->increments('id');
			$t->integer('form_id')->unsigned();
			$t->integer('tab_id')->unsigned()->default(0);
			$t->string('name')->nullable();
			$t->integer('order');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('form_tabs', function($t)
		{
			$t->increments('id');
			$t->integer('form_id')->unsigned();
			$t->string('name');
			$t->string('link_id')->nullable();
			$t->integer('order');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('form_values', function($t)
		{
			$t->increments('id');
			$t->integer('field_id')->unsigned();
			$t->string('value');
			$t->integer('order');
			$t->timestamps();
		});
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

}