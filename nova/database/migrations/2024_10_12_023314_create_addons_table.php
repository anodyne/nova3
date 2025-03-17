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
            $table->string('name');
            $table->string('location')->unique();
            $table->string('version');
            $table->text('credits')->nullable();
            $table->text('preview')->nullable();
            $table->string('type');
            $table->string('status')->default(BasicStatus::Active->value);
            $table->json('settings')->nullable();
            $table->json('repository')->nullable();
            $table->datetimes();

            $table->fullText(['name', 'location']);
            $table->index(['type', 'status']);
            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};
