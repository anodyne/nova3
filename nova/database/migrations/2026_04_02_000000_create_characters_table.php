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
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->string('name')->index();
            $table->string('type')->nullable()->index();
            $table->string('status')->index();
            $table->foreignUuid('rank_id')->nullable()->constrained('rank_items');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('character_position', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('character_id')->constrained();
            $table->foreignUuid('position_id')->constrained();
        });

        Schema::create('character_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('character_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->boolean('primary')->index();
            $table->timestamps();
        });
    }
};
