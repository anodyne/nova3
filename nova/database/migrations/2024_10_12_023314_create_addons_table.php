<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\BasicStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name')->index();
            $table->string('location')->unique();
            $table->string('version');
            $table->text('credits')->nullable();
            $table->text('preview')->nullable();
            $table->string('type')->index();
            $table->string('status')->default(BasicStatus::Active->value)->index();
            $table->json('settings')->nullable();
            $table->json('repository')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};
