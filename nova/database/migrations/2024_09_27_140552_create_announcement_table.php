<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Announcements\Models\Announcement;
use Nova\Users\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignIdFor(User::class);
            $table->string('title');
            $table->string('category')->nullable();
            $table->longText('content');
            $table->boolean('published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('announcement_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Announcement::class)->onDelete('cascade');
            $table->foreignIdFor(User::class);
            $table->boolean('is_seen')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'announcement_id'], 'user_announcement_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
