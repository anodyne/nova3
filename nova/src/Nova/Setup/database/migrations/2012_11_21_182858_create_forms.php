<?php

use Illuminate\Database\Migrations\Migration;

class CreateForms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms', function($table)
		{
			$table->increments('id');
			$table->string('key', 20);
			$table->string('name');
			$table->string('orientation', 50)->default('vertical');
		});

		Schema::create('form_data', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('form_key', 20);
			$table->integer('field_id')->unsigned();
			$table->integer('user_id')->nullable();
			$table->integer('character_id')->nullable();
			$table->integer('item_id')->nullable();
			$table->text('value')->nullable();
			$table->datetime('updated_at');
		});

		Schema::create('form_fields', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('form_key', 20);
			$table->integer('section_id')->nullable();
			$table->string('type', 50)->default('text');
			$table->string('label');
			$table->integer('order')->nullable();
			$table->boolean('status')->default(3);
			$table->integer('restriction')->nullable();
			$table->text('help')->nullable();
			$table->string('selected', 50)->nullable();
			$table->string('value')->nullable();
			$table->string('html_name')->nullable();
			$table->string('html_id')->nullable();
			$table->string('html_class')->nullable();
			$table->integer('html_rows')->default(5);
			$table->text('placeholder')->nullable();
			$table->datetime('updated_at');
		});

		Schema::create('form_sections', function($table)
		{
			$table->increments('id');
			$table->string('form_key', 20);
			$table->integer('tab_id')->nullable();
			$table->string('name')->nullable();
			$table->integer('order');
			$table->boolean('status')->default(3);
			$table->datetime('updated_at');
		});

		Schema::create('form_tabs', function($table)
		{
			$table->increments('id');
			$table->string('form_key', 20);
			$table->string('name');
			$table->string('link_id', 20)->nullable();
			$table->integer('order')->nullable();
			$table->boolean('status')->default(3);
			$table->datetime('updated_at');
		});

		Schema::create('form_values', function($table)
		{
			$table->increments('id');
			$table->integer('field_id')->unsigned();
			$table->string('value');
			$table->text('content');
			$table->integer('order');
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
