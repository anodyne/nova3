<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name')->index();
            $table->string('type')->default('support')->index();
            $table->string('status')->index();
            $table->foreignId('rank_id')->nullable();
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        Schema::create('character_position', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id');
            $table->foreignId('position_id');
        });

        Schema::create('character_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id');
            $table->foreignId('user_id');
            $table->boolean('primary')->default(false)->index();
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_position');
        Schema::dropIfExists('character_user');
        Schema::dropIfExists('characters');
    }
};
