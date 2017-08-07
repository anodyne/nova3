<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTables extends Migration
{
	public function up()
	{
		Schema::create('media', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('mediable_id');
			$table->string('mediable_type');
			$table->string('filename');
			$table->string('mime_type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('media');
	}
}
