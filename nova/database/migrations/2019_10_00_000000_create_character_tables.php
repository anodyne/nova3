<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('status');
            $table->foreignId('rank_id')->nullable()->constrained('rank_items');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('character_position', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained('characters');
            $table->foreignId('position_id')->constrained('positions');
            $table->boolean('primary')->default(false);
        });

        Schema::create('character_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained('characters');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_position');
        Schema::dropIfExists('character_user');
        Schema::dropIfExists('characters');
    }
}
