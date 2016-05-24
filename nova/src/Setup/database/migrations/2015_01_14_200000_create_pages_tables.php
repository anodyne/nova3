<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTables extends Migration {

	public function up()
	{
		Schema::create('pages', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('menu_id')->unsigned()->default(0);
			$table->string('type', 15);
			$table->string('verb', 10)->default('GET');
			$table->string('name'); // Used as a descriptive name of the page
			$table->text('description')->nullable();
			$table->string('key'); // Used as the route name
			$table->string('uri');
			$table->text('resource')->nullable();
			$table->string('default_resource')
				->default('Nova\\\Foundation\\\Http\\\Controllers\\\MainController@page');
			$table->string('access_type')->nullable();
			$table->string('access')->nullable();
			$table->text('conditions')->nullable();
			$table->boolean('protected')->default((int) false);
			$table->timestamps();
		});

		Schema::create('pages_content', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('page_id')->unsigned()->nullable();
			$table->string('type', 10);
			$table->string('key');
			$table->longtext('value')->nullable();
			$table->boolean('protected')->default((int) false);
			$table->timestamps();
		});

		$this->populateTables();
	}

	public function down()
	{
		Schema::dropIfExists('pages');
		Schema::dropIfExists('pages_content');
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
			$content['protected'] = (int) true;

			PageContent::create($content);
		}
	}

}
