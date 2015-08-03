<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('key');
			$table->timestamps();
		});

		Schema::create('menus_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('menu_id')->unsigned();
			$table->integer('parent_id')->default(0);
			$table->integer('order')->default(99);
			$table->string('type')->default('page');
			$table->integer('page_id')->nullable();
			$table->string('link')->nullable();
			$table->string('title')->nullable();
			$table->boolean('authentication')->default((int) true);
			$table->timestamps();
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
		Schema::dropIfExists('menus');
		Schema::dropIfExists('menus_items');
	}

	protected function populateTables()
	{
		Model::unguard();

		$data = require_once app('path.database').'/data/menus.php';

		foreach ($data['menus'] as $menu)
		{
			Menu::create($menu);
		}

		foreach ($data['menuItems'] as $item)
		{
			MenuItem::create($item);
		}
	}

}
