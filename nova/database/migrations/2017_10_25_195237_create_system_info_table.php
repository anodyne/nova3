<?php

use Nova\Foundation\SystemInfo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemInfoTable extends Migration
{
	public function up()
	{
		Schema::create('system_info', function (Blueprint $table) {
			$table->increments('id');
			$table->string('version')->default(config('nova.version'));
			$table->tinyInteger('install_phase')->default(0);
			// $table->text('install_checklist')->nullable();
			$table->tinyInteger('migration_phase')->default(0);
			// $table->text('migration_checklist')->nullable();
			$table->tinyInteger('update_phase')->default(0);
			$table->timestamps();
		});

		// $installChecklist = [
		// 	['key' => 'settings', 'complete' => false],
		// 	['key' => 'genre-data', 'complete' => false],
		// 	['key' => 'ranks', 'complete' => false],
		// 	['key' => 'email-test', 'complete' => false],
		// ];
		$migrationChecklist = [];

		SystemInfo::create([
			// 'install_checklist' => json_encode($installChecklist),
			// 'migration_checklist' => json_encode($migrationChecklist),
		]);
	}

	public function down()
	{
		Schema::dropIfExists('system_info');
	}
}
