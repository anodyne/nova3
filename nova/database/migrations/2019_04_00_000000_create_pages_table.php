<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Pages\Enums\PageStatus;
use Nova\Pages\Enums\PageVerb;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name');
            $table->string('uri');
            $table->string('key')->nullable();
            $table->string('verb')->default(PageVerb::get->value);
            $table->string('resource')->nullable();
            $table->string('layout')->default('public');
            $table->text('middleware')->nullable();
            $table->longText('blocks')->nullable();
            $table->longText('published_blocks')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('status')->default(PageStatus::active->value);
            $table->dateTime('published_at')->nullable();
            $table->boolean('content_can_be_edited')->default(false);
            $table->text('heading')->nullable();
            $table->text('subheading')->nullable();
            $table->longText('intro')->nullable();
            $table->timestamps();

            $table->index('key');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
