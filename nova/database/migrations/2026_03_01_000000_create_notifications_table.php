<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->uuidMorphs('notifiable');
            $table->text('data');
            $table->dateTime('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('notification_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->string('key')->unique();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('audience');
            $table->boolean('database');
            $table->boolean('database_default');
            $table->boolean('mail');
            $table->boolean('mail_default');
            $table->boolean('discord');
            $table->json('discord_settings')->nullable();
            $table->timestamps();
        });

        Schema::create('user_notification_preferences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('notification_type_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->boolean('database');
            $table->boolean('mail');
            $table->boolean('discord');
            $table->json('discord_settings')->nullable();
        });
    }
};
