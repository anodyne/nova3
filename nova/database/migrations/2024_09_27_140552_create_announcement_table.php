<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignId('user_id')->constrained();
            $table->string('title')->index();
            $table->string('category')->nullable()->index();
            $table->longText('content');
            $table->boolean('published')->default(false)->index();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('announcement_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_seen')->default(false)->index();
            $table->timestamps();

            $table->index(['user_id', 'announcement_id'], 'user_announcement_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_notifications');
        Schema::dropIfExists('announcements');
    }
};
