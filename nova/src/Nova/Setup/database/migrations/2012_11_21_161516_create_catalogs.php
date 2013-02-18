<?php

use Illuminate\Database\Migrations\Migration;

class CreateCatalogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalog_modules', function($table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('short_name', 50)->nullable();
			$table->string('location');
			$table->text('desc')->nullable();
			$table->boolean('protected')->default(0);
			$table->boolean('status')->default(3);
			$table->text('credits')->nullable();
			$table->timestamps();
		});

		Schema::create('catalog_ranks', function($table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('location');
			$table->string('preview', 50)->default('preview.png');
			$table->string('blank', 50)->default('blank.png');
			$table->string('extension', 5)->default('.png');
			$table->boolean('status')->default(3);
			$table->text('credits')->nullable();
			$table->boolean('default')->default(0);
			$table->string('genre', 10);
			$table->timestamps();
		});

		Schema::create('catalog_skins', function($table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('location');
			$table->text('credits')->nullable();
			$table->string('version', 10)->nullable();
			$table->timestamps();
		});

		Schema::create('catalog_skinsecs', function($table)
		{
			$table->increments('id');
			$table->string('section', 50);
			$table->string('skin', 100);
			$table->string('preview', 50)->nullable();
			$table->boolean('status')->default(3);
			$table->boolean('default')->default(0);
			$table->string('nav', 20)->default('dropdown');
			$table->timestamps();
		});

		Schema::create('catalog_widgets', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('location');
			$table->string('page', 100);
			$table->boolean('zone')->nullable();
			$table->boolean('status')->default(3);
			$table->text('credits')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('catalog_modules');
		Schema::drop('catalog_ranks');
		Schema::drop('catalog_skins');
		Schema::drop('catalog_skinsecs');
		Schema::drop('catalog_widgets');
	}
}
