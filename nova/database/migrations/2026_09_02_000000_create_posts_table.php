<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignId('story_id')->nullable()->constrained();
            $table->foreignId('post_type_id')->nullable()->constrained();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->string('status')->index();
            $table->string('title')->nullable()->index();
            $table->longText('content')->nullable();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('word_count')->default(0);
            $table->string('rating_language')->nullable()->default('0');
            $table->string('rating_sex')->nullable()->default('0');
            $table->string('rating_violence')->nullable()->default('0');
            $table->longText('summary')->nullable();
            $table->text('participants')->nullable();
            $table->integer('neighbor')->nullable();
            $table->string('direction', 6)->nullable();
            $table->dateTime('published_at')->nullable()->index();
            $table->dateTime('locked_at')->nullable();
            $table->unsignedBigInteger('locked_by')->nullable();
            $table->unsignedBigInteger('last_update_by')->nullable();
            $table->datetimes();
            $table->softDeletesDatetime();

            $table->index('locked_at');
        });

        Schema::create('post_author', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained();
            $table->morphs('authorable');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->text('as')->nullable();
            $table->integer('word_count')->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index('post_id');
            $table->index('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_author');
        Schema::dropIfExists('posts');
    }
};
