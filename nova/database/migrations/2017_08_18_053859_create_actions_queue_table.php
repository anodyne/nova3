<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsQueueTable extends Migration
{
	public function up()
	{
		// Schema::create('actions_queue', function (Blueprint $table) {
		// 	$table->bigIncrements('id');
		// 	$table->unsignedTinyInteger('status')->default(Status::PENDING);
		// 	$table->unsignedInteger('user_id');
		// 	$table->string('resource');
		// 	$table->unsignedInteger('resource_id')->nullable();
		// 	$table->string('action');
		// 	$table->longText('payload')->nullable();
		// 	$table->timestamps();
		// });

		// John Doe created a new position.
		// Jane Doe updated the Homepage page.
	}

	public function down()
	{
		Schema::dropIfExists('actions_queue');
	}
}
