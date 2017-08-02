<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTables extends Migration
{
	public function up()
	{
		Schema::create('characters', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('user_id')->nullable();
			$table->unsignedInteger('position_id');
			$table->unsignedInteger('rank_id')->nullable();
			$table->string('name')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('characters');
	}
}
