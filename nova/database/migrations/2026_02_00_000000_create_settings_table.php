<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->json('general')->nullable();
            $table->json('email')->nullable();
            $table->json('appearance')->nullable();
            $table->json('characters')->nullable();
            $table->json('discord')->nullable();
            $table->json('posting_activity')->nullable();
            $table->json('ratings')->nullable();
            $table->json('applications')->nullable();
            $table->json('dashboard')->nullable();
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
