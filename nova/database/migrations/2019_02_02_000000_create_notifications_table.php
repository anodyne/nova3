<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Foundation\Enums\NotificationChannelStatus;
use Nova\Foundation\Models\NotificationType;
use Nova\Users\Models\User;

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
            $table->string('name');
            $table->string('key')->unique();
            $table->text('description')->nullable();
            $table->string('audience')->default(NotificationAudience::personal->value);
            $table->string('database')->default(NotificationChannelStatus::enabled->value);
            $table->string('mail')->default(NotificationChannelStatus::enabled->value);
            $table->string('discord')->default(NotificationChannelStatus::disabled->value);
            $table->timestamps();
        });

        Schema::create('user_notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NotificationType::class);
            $table->foreignIdFor(User::class)->nullable();
            $table->string('database')->default(NotificationChannelStatus::enabled->value);
            $table->string('mail')->default(NotificationChannelStatus::enabled->value);
            $table->string('discord')->default(NotificationChannelStatus::disabled->value);
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
