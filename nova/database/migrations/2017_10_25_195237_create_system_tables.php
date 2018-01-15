<?php

use Nova\Foundation\SystemInfo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTables extends Migration
{
	public function up()
	{
		Schema::create('system_info', function (Blueprint $table) {
			$table->increments('id');
			$table->string('version')->default(config('nova.version'));
			$table->tinyInteger('install_phase')->default(0);
			$table->tinyInteger('migration_phase')->default(0);
			$table->tinyInteger('update_phase')->default(0);
			$table->timestamps();
		});

		Schema::create('system_extensions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('description')->nullable();
			$table->text('credits')->nullable();
			$table->string('author');
			$table->string('version')->nullable();
			$table->text('link')->nullable();
			$table->string('vendor');
			$table->string('name');
			$table->boolean('status')->default(Status::ACTIVE);
			$table->integer('order')->default(99);
			$table->timestamps();
		});

		SystemInfo::create([]);
	}

	public function down()
	{
		Schema::dropIfExists('system_info');
		Schema::dropIfExists('system_extensions');
	}
}
