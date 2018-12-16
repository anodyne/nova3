<?php

use Nova\Pages\Page;
use Nova\Content\ContentType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('content_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('key')->unique();
			$table->string('name');
			$table->timestamps();
			$table->softDeletes();
		});

        Schema::create('content', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('contentable_id');
			$table->string('contentable_type');
			$table->unsignedInteger('type_id');
			$table->unsignedInteger('order');
			$table->longText('content');
			$table->timestamps();

			$table->foreign('type_id')->references('id')->on('content_types');
		});

		$this->populateContentTypes();
		$this->populateContent();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('content');
        Schema::dropIfExists('content_types');
	}

	protected function populateContentTypes()
	{
		$dates = [
			'created_at' => now(),
			'updated_at' => now(),
		];

		$contentTypes = [
            array_merge(['key' => 'page-header', 'name' => 'Page Header'], $dates),
            array_merge(['key' => 'page-title', 'name' => 'Page Title'], $dates),
            array_merge(['key' => 'page-content', 'name' => 'Page Content'], $dates),
        ];

		ContentType::insert($contentTypes);
	}

	protected function populateContent()
	{
		$content = collect([
			'sign-in' => [
				['type_id' => 1, 'order' => 0, 'content' => 'Sign In'],
				['type_id' => 2, 'order' => 0, 'content' => 'Sign In'],
				['type_id' => 3, 'order' => 0, 'content' => 'Sign In'],
			],
			'password.request' => [
				['type_id' => 1, 'order' => 0, 'content' => 'Forgot Your Password?'],
				['type_id' => 2, 'order' => 0, 'content' => 'Forgot Your Password?'],
				['type_id' => 3, 'order' => 0, 'content' => 'Forgot Your Password?'],
			],
			'password.reset' => [
				['type_id' => 1, 'order' => 0, 'content' => 'Reset Password'],
				['type_id' => 2, 'order' => 0, 'content' => 'Reset Password'],
				['type_id' => 3, 'order' => 0, 'content' => 'Reset Password'],
			],

			'dashboard' => [
				['type_id' => 1, 'order' => 0, 'content' => 'Dashboard'],
				['type_id' => 2, 'order' => 0, 'content' => 'Dashboard'],
				['type_id' => 3, 'order' => 0, 'content' => 'Dashboard'],
			],

			'admin.themes' => [
				['type_id' => 1, 'order' => 0, 'content' => 'Themes'],
				['type_id' => 2, 'order' => 0, 'content' => 'Themes'],
				['type_id' => 3, 'order' => 0, 'content' => 'Themes'],
			],
		]);

		Page::get()->each(function ($page) use ($content) {
			if ($content->has($page->key)) {
				collect($content->get($page->key))
					->each(function ($c) use ($page) {
						$page->content()->create($c);
					});
			}
		});
	}
}
