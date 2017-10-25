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
			$table->timestamps();
		});

		SystemInfo::create([]);
	}

	public function down()
	{
		Schema::dropIfExists('system_info');
	}
}
