<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();
            $table->string('status');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        Schema::create('post_author', function (Blueprint $table) {
            $table->id();
            $table->morphs('authorable');
        });

        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->foreignId('role_id')->nullable()->constrained();
            $table->string('status');
            $table->string('visibility')->default('in-character');
            $table->json('fields')->nullable();
            $table->json('options')->nullable();
            $table->unsignedBigInteger('sort')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories');
            $table->foreignId('post_type_id')->nullable()->constrained('post_types');
            $table->string('status');
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('word_count')->default(0);
            $table->unsignedSmallInteger('rating_language')->default(0);
            $table->unsignedSmallInteger('rating_sex')->default(0);
            $table->unsignedSmallInteger('rating_violence')->default(0);
            $table->nestedSet();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['story_id', 'post_type_id', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_author');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_types');
        Schema::dropIfExists('stories');
    }
}
