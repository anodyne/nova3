<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\BasicStatus;

class CreateRankTables extends Migration
{
    public function up()
    {
        Schema::create('rank_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('status')->default(BasicStatus::Active)->index();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('rank_names', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('status')->default(BasicStatus::Active)->index();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('rank_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('rank_groups');
            $table->foreignId('name_id')->constrained('rank_names');
            $table->string('base_image');
            $table->string('overlay_image')->nullable();
            $table->string('status')->default(BasicStatus::Active)->index();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rank_groups');
        Schema::dropIfExists('rank_names');
        Schema::dropIfExists('rank_items');
    }
}
