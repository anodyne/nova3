<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Roles\Models\Role;
use Nova\Stories\Enums\PostTypeStatus;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class CreateStoryTables extends Migration
{
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignIdFor(Story::class, 'parent_id')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->string('status')->index();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->timestamps();
        });

        Schema::create('post_author', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class);
            $table->morphs('authorable');
            $table->foreignIdFor(User::class)->nullable();
            $table->text('as')->nullable();
            $table->integer('word_count')->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index('post_id');
            $table->index('updated_at');
        });

        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('key')->unique();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->foreignIdFor(Role::class)->nullable()->constrained();
            $table->string('status')->default(PostTypeStatus::Active->value)->index();
            $table->string('visibility')->default('in-character')->index();
            $table->json('fields')->nullable();
            $table->json('options')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignIdFor(Story::class)->nullable()->constrained();
            $table->foreignIdFor(PostType::class)->nullable()->constrained();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->string('status')->index();
            $table->string('title')->nullable()->index();
            $table->longText('content')->nullable();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('word_count')->default(0);
            $table->unsignedSmallInteger('rating_language')->nullable()->default(0);
            $table->unsignedSmallInteger('rating_sex')->nullable()->default(0);
            $table->unsignedSmallInteger('rating_violence')->nullable()->default(0);
            $table->longText('summary')->nullable();
            $table->text('participants')->nullable();
            $table->integer('neighbor')->nullable();
            $table->string('direction', 6)->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('locked_at')->nullable();
            $table->unsignedBigInteger('locked_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('locked_at');
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
