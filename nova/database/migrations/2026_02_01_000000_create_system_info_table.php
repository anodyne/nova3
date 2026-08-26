<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_info', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('version');
            $table->string('anodyne_game_id')->nullable();
            $table->dateTime('install_date')->nullable();
            $table->dateTime('last_update')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_info');
    }
};
