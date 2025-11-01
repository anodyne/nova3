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
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('title');
            $table->string('category')->nullable();
            $table->longText('content');
            $table->string('status')->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->datetimes();

            $table->index(['status', 'category']);
            $table->index(['status', 'published_at']);
            $table->index('category');
            $table->index('status');
            $table->fullText('title');
        });

        Schema::create('announcement_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_seen')->default(false);
            $table->datetimes();

            $table->index(['announcement_id', 'user_id']);
            $table->index(['user_id', 'is_seen']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_notifications');
        Schema::dropIfExists('announcements');
    }
};
