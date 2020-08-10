<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('status');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->nestedSet();
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
            $table->boolean('active')->default(true);
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
            $table->foreignId('post_type_id')->constrained('post_types');
            $table->string('status');
            $table->string('title');
            $table->longText('content');
            $table->boolean('mature_content')->default(false);
            $table->dateTime('published_at')->nullable();
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
