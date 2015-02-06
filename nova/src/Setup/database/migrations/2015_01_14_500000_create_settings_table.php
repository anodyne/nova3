<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key');
			$table->text('value');
			$table->string('label')->nullable();
			$table->boolean('user_created')->default((int) true);
			$table->timestamps();
		});

		$this->populateTable();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('settings');
	}

	protected function populateTable()
	{
		$settings = require_once app('path.database').'/data/settings.php';

		foreach ($settings as $setting)
		{
			app('SettingRepository')->create($setting);
		}
	}

}
