<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onboarding', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->text('description')->nullable();
            $table->text('onboarding_class');
            $table->datetimes();
        });

        Schema::create('onboarding_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onboarding_id');
            $table->foreignId('user_id');
            $table->dateTime('completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onboarding_user');
        Schema::dropIfExists('onboarding');
    }
};
