<?php

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
            $table->foreignId('story_id')->nullable()->constrained('stories');
            $table->string('status');
            $table->string('title');
            $table->text('description');
            $table->text('summary')->nullable();
            $table->unsignedInteger('sort')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('post_author', function (Blueprint $table) {
            $table->id();
            $table->morphs('authorable');
        });

        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description');
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories')->onDelete('cascade');
            $table->foreignId('post_type_id')->constrained('post_types');
            $table->string('status');
            $table->string('title');
            $table->longText('content');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
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
