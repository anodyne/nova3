<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('location')->unique();
            $table->string('version');
            $table->text('credits')->nullable();
            $table->text('preview')->nullable();
            $table->string('status')->default('active')->index();
            $table->json('settings');
            $table->json('repository')->nullable();
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
