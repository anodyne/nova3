<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTables extends Migration {

	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('type', 15);
			$table->string('name'); // Used as a descriptive name of the page
			$table->text('description')->nullable();
			$table->string('key'); // Used as the route name
			$table->string('uri');
			$table->string('verb', 10)->default('GET');
			$table->text('resource')->nullable();
			$table->string('default_resource')->default('Nova\\\Foundation\\\Http\\\Controllers\\\MainController@page');
			$table->text('conditions')->nullable();
			$table->boolean('protected')->default((int) false);
			$table->timestamps();
		});

		Schema::create('pages_content', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('page_id')->unsigned();
			$table->string('type', 10);
			$table->string('key');
			$table->text('value');
			$table->timestamps();
		});

		/*Schema::create('pages_navigation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('page_id')->unsigned();
			$table->timestamps();
		});*/

		$this->populateTables();
	}

	public function down()
	{
		Schema::dropIfExists('pages');
		Schema::dropIfExists('pages_content');
		//Schema::dropIfExists('pages_navigation');
	}

	protected function populateTables()
	{
		Model::unguard();

		$data['pages'] = require_once app('path.database').'/data/pages.php';
		$data['content'] = require_once app('path.database').'/data/pages_content.php';

		foreach ($data['pages'] as $page)
		{
			$page['type'] = (Str::contains($page['default_resource'], "MainController@page"))
				? 'basic'
				: 'advanced';
			$page['protected'] = (int) true;

			Page::create($page);
		}

		foreach ($data['content'] as $content)
		{
			PageContent::create($content);
		}
	}

}
