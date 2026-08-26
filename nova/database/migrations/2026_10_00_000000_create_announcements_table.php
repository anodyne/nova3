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
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->foreignUuid('user_id')->nullable()->constrained();
            $table->string('title');
            $table->string('category')->nullable();
            $table->longText('content');
            $table->string('status')->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'category']);
            $table->index(['status', 'published_at']);
            $table->index('category');
            $table->index('status');
            $table->fullText('title');
        });

        Schema::create('announcement_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('announcement_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->boolean('is_seen')->default(false);
            $table->timestamps();

            $table->index(['announcement_id', 'user_id']);
            $table->index(['user_id', 'is_seen']);
        });
    }
};
