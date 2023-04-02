<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\SystemNotificationType;
use Nova\Foundation\Models\SystemNotification;
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

        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->text('description')->nullable();
            $table->string('type')->default(SystemNotificationType::personal->value);
            $table->boolean('web')->default(true);
            $table->boolean('email')->default(true);
            $table->boolean('discord')->default(false);
            $table->timestamps();
        });

        Schema::create('notifiables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(SystemNotification::class);
            $table->boolean('web')->default(true);
            $table->boolean('email')->default(true);
            $table->boolean('discord')->default(false);
            $table->json('discord_settings')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifiables');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('system_notifications');
    }
}
