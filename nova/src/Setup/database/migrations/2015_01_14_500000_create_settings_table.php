<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
	public function up()
	{
		Schema::create('settings', function (Blueprint $table) {
			$table->increments('id');
			$table->string('key');
			$table->text('value');
			$table->string('label')->nullable();
			$table->boolean('protected')->default((int) false);
			$table->timestamps();
		});

		$this->populateTable();
	}

	public function down()
	{
		Schema::dropIfExists('settings');
	}

	protected function populateTable()
	{
		Model::unguard();

		$settings = require_once app('path.database').'/data/settings.php';

		foreach ($settings as $setting) {
			$setting['protected'] = (int) true;

			app('SettingRepository')->create($setting);
		}
	}
}
