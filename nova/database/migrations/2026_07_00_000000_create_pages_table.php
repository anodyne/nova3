<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->string('name');
            $table->string('uri');
            $table->string('key')->nullable()->index();
            $table->string('verb');
            $table->string('resource')->nullable();
            $table->string('layout');
            $table->text('middleware')->nullable();
            $table->longText('blocks')->nullable();
            $table->longText('published_blocks')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('status');
            $table->dateTime('published_at')->nullable();
            $table->boolean('content_can_be_edited');
            $table->text('heading')->nullable();
            $table->text('subheading')->nullable();
            $table->longText('intro')->nullable();
            $table->timestamps();
        });
    }
};
