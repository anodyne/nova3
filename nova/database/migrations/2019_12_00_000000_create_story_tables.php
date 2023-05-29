<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Enums\PostTypeStatus;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class CreateStoryTables extends Migration
{
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Story::class, 'parent_id')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
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
            $table->foreignIdFor(Post::class);
            $table->morphs('authorable');
            $table->foreignIdFor(User::class)->nullable();
            $table->text('as')->nullable();
        });

        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->foreignId('role_id')->nullable()->constrained();
            $table->string('status')->default(PostTypeStatus::active->value);
            $table->string('visibility')->default('in-character');
            $table->json('fields')->nullable();
            $table->json('options')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Story::class)->nullable();
            $table->foreignIdFor(PostType::class)->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
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
            $table->longText('summary')->nullable();
            $table->text('participants')->nullable();
            $table->integer('neighbor')->nullable();
            $table->string('direction', 6)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['story_id', 'post_type_id', 'published_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_author');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_types');
        Schema::dropIfExists('stories');
    }
}
