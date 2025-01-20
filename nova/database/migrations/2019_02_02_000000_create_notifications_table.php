<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\NotificationAudience;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('notification_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('key')->unique();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('audience')->default(NotificationAudience::Personal);
            $table->boolean('database')->default(true);
            $table->boolean('database_default')->default(true);
            $table->boolean('mail')->default(false);
            $table->boolean('mail_default')->default(false);
            $table->boolean('discord')->default(false);
            $table->json('discord_settings')->nullable();
            $table->timestamps();
        });

        Schema::create('user_notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_type_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('database')->default(true);
            $table->boolean('mail')->default(false);
            $table->boolean('discord')->default(false);
            $table->json('discord_settings')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_notification_preferences');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('notification_types');
    }
}
