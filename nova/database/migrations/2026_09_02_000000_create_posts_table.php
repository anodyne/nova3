<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->foreignUuid('story_id')->nullable()->constrained();
            $table->foreignUuid('post_type_id')->nullable()->constrained();
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
            $table->timestamps();
            $table->softDeletes();

            $table->index('locked_at');
        });

        Schema::create('post_author', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained();
            $table->uuidMorphs('authorable');
            $table->foreignUuid('user_id')->nullable()->constrained();
            $table->text('as')->nullable();
            $table->integer('word_count')->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index('post_id');
            $table->index('updated_at');
        });
    }
};
