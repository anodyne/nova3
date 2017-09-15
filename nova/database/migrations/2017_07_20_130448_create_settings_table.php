<?php

use Nova\Settings\Settings;
use Illuminate\Support\Facades\Schema;
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
			$table->boolean('protected')->default((int) false);
			$table->timestamps();
		});

		$this->seed();
	}

	public function down()
	{
		Schema::dropIfExists('settings');
	}

	protected function seed()
	{
		$settings = collect([
			['key' => 'rank', 'value' => 'duty', 'protected' => (int)true],
			['key' => 'manifest_show_assigned', 'value' => 'true', 'protected' => (int)true],
			['key' => 'manifest_show_inactive', 'value' => 'false', 'protected' => (int)true],
			['key' => 'manifest_show_npcs', 'value' => 'true', 'protected' => (int)true],
			['key' => 'manifest_show_available', 'value' => 'true', 'protected' => (int)true],
		]);

		Eloquent::unguard();

		$settings->each(function ($s) {
			factory(Settings::class)->create($s);
		});

		Eloquent::reguard();
	}
}
