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
			$t->integer('form_id');
			$t->integer('field_id')->unsigned();
			$t->integer('data_id');
			$t->text('value')->nullable();
			$t->timestamps();
		});

		Schema::create('form_fields', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('form_id');
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
			$t->integer('form_id');
			$t->integer('tab_id')->nullable();
			$t->string('name')->nullable();
			$t->integer('order');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('form_tabs', function($t)
		{
			$t->increments('id');
			$t->integer('form_id');
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