<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateCatalogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalog_modules', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('short_name', 50)->nullable();
			$t->string('location');
			$t->text('desc')->nullable();
			$t->boolean('protected')->default((int) false);
			$t->boolean('status')->default(Status::ACTIVE);
			$t->text('credits')->nullable();
			$t->timestamps();
		});

		Schema::create('catalog_ranks', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('location');
			$t->string('preview', 50)->default('preview.png');
			$t->string('blank', 50)->default('blank.png');
			$t->string('extension', 5)->default('.png');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->text('credits')->nullable();
			$t->boolean('default')->default((int) false);
			$t->string('genre', 10);
			$t->timestamps();
		});

		Schema::create('catalog_skins', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('location');
			$t->string('nav', 20)->default('dropdown');
			$t->string('preview')->nullable();
			$t->text('credits')->nullable();
			$t->string('version', 10)->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->text('options')->nullable();
			$t->boolean('has_main')->default((int) false);
			$t->boolean('has_admin')->default((int) false);
			$t->boolean('has_login')->default((int) false);
			$t->timestamps();
		});

		Schema::create('catalog_widgets', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('location');
			$t->string('page', 100);
			$t->boolean('zone')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->text('credits')->nullable();
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
		Schema::drop('catalog_modules');
		Schema::drop('catalog_ranks');
		Schema::drop('catalog_skins');
		Schema::drop('catalog_widgets');
	}

}