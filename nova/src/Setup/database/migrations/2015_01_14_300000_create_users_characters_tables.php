<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCharactersTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 100);
			$table->string('password', 96)->nullable();
			$table->string('name');
			$table->string('nickname')->nullable();
			$table->string('gender', 10)->default('male');
			$table->boolean('status')->default((int) Status::PENDING);
			$table->string('api_token', 60)->nullable()->unique();
			$table->rememberToken();
			$table->timestamp('last_password_reset')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('users_password_resets', function (Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});

		Schema::create('users_preferences', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->string('key');
			$table->string('value')->nullable();
		});

		Schema::create('users_preferences_defaults', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('key');
			$table->string('default')->nullable();
			$table->boolean('protected')->default((int) false);
		});

		Schema::create('characters', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('first_name');
			$table->string('middle_name')->nullable();
			$table->string('last_name')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade');
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
		Schema::dropIfExists('characters');
		Schema::dropIfExists('users_preferences_defaults');
		Schema::dropIfExists('users_preferences');
		Schema::dropIfExists('users_password_resets');
		Schema::dropIfExists('users');
	}

	protected function populateTables()
	{
		Model::unguard();

		$data = require_once app('path.database').'/data/users.php';

		$defaultPrefsRepo = app('PreferenceDefaultRepository');

		foreach ($data['preferenceDefaults'] as $default)
		{
			$defaultPrefsRepo->create($default);
		}
	}

}
