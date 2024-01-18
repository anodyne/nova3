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
            $table->string('uri');
            $table->string('key')->nullable();
            $table->string('verb')->default(PageVerb::get->value);
            $table->string('resource')->nullable();
            $table->string('layout')->default('public');
            $table->json('blocks')->nullable();
            $table->string('status')->default(PageStatus::active->value);
            $table->timestamps();

            $table->index('key');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
