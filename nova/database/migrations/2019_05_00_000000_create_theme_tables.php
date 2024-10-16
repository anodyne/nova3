<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Themes\Enums\ThemeStatus;

class CreateThemeTables extends Migration
{
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->text('credits')->nullable();
            $table->text('preview')->nullable();
            $table->string('status')->default(ThemeStatus::active->value);
            $table->json('settings');
            $table->timestamps();

            $table->index(['location', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
