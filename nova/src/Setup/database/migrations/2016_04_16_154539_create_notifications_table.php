<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
	public function up()
	{
		Schema::create('notifications', function (Blueprint $table) {
			$table->string('id')->primary();
			$table->string('type');
			$table->morphs('notifiable');
			$table->text('data');
			$table->timestamp('read_at')->nullable();
			$table->timestamps();
		});

		/*Schema::create('notifications', function (Blueprint $table) {
			$table->string('id')->primary();
			$table->integer('user_id');
			$table->integer('created_by')->nullable(); // Null created_by means the system created it
			$table->string('icon', 50)->nullable();
			$table->text('body');
			$table->string('action_text')->nullable();
			$table->text('action_url')->nullable();
			$table->tinyInteger('read')->default((int) false);
			$table->timestamps();

			$table->index(['user_id', 'created_at']);
		});*/
	}

	public function down()
	{
		Schema::dropIfExists('notifications');
	}
}
