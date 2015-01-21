<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTables extends Migration {

	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('collection_id')->unsigned();
			$table->string('type', 10)->default('GET');
			$table->string('name');
			$table->string('uri');
			$table->string('key');
			$table->text('resource')->nullable();
			$table->text('default_resource')->nullable();
			$table->boolean('protected')->default((int) false);
			$table->text('description')->nullable();
			$table->timestamps();
		});

		Schema::create('pages_collections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug')->nullable();
			$table->string('prefix')->nullable();
			$table->timestamps();
		});

		Schema::create('pages_content', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('page_id')->unsigned();
			$table->string('type', 10);
			$table->string('key');
			$table->text('content');
			$table->timestamps();
		});

		Schema::create('pages_navigation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('page_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('pages');
		Schema::dropIfExists('pages_collections');
		Schema::dropIfExists('pages_content');
		Schema::dropIfExists('pages_navigation');
	}

}
