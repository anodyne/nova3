<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\BasicStatus;

class CreateThemeTables extends Migration
{
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('location')->unique();
            $table->string('version');
            $table->text('credits')->nullable();
            $table->text('preview')->nullable();
            $table->string('status')->default(BasicStatus::Active)->index();
            $table->json('settings');
            $table->json('repository')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
